<?php
// Simple content-based recommendations using cosine similarity.
// Features: normalized rent, location tokens, amenity tokens (from property_description),
// and categorical tokens for property/landlord.

if (!function_exists('tokenize_text')) {
    function tokenize_text(string $text): array
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', ' ', $text);
        $parts = preg_split('/\s+/', trim($text));
        $stopwords = [
            'and', 'or', 'the', 'with', 'near', 'from', 'at', 'in', 'of', 'a', 'an',
            'to', 'for', 'on', 'by', 'is', 'are', 'be', 'this', 'that'
        ];
        $tokens = [];
        foreach ($parts as $part) {
            if ($part === '' || strlen($part) < 2) {
                continue;
            }
            if (in_array($part, $stopwords, true)) {
                continue;
            }
            $tokens[$part] = true;
        }
        return array_keys($tokens);
    }
}

if (!function_exists('room_tokens')) {
    function room_tokens(array $room): array
    {
        // property_description is used as amenity text.
        $text = ($room['property_location'] ?? '') . ' ' .
            ($room['property_description'] ?? '') . ' ' .
            ($room['property_name'] ?? '');

        $tokens = [];
        foreach (tokenize_text($text) as $token) {
            $tokens[$token] = true;
        }
        if (!empty($room['property_id'])) {
            $tokens['property:' . $room['property_id']] = true;
        }
        if (!empty($room['property_manager_id'])) {
            $tokens['landlord:' . $room['property_manager_id']] = true;
        }
        return array_keys($tokens);
    }
}

if (!function_exists('build_vocab_index')) {
    function build_vocab_index(array $rooms): array
    {
        $vocab = [];
        foreach ($rooms as $room) {
            foreach (room_tokens($room) as $token) {
                $vocab[$token] = true;
            }
        }
        $tokens = array_keys($vocab);
        return array_flip($tokens);
    }
}

if (!function_exists('room_vector')) {
    function room_vector(array $room, array $vocab_index, float $max_rent): array
    {
        $vector = array_fill(0, count($vocab_index) + 1, 0.0);
        $rent = isset($room['room_rent_amount']) ? (float)$room['room_rent_amount'] : 0.0;
        $vector[0] = $max_rent > 0 ? $rent / $max_rent : 0.0;

        foreach (room_tokens($room) as $token) {
            if (isset($vocab_index[$token])) {
                $vector[$vocab_index[$token] + 1] = 1.0;
            }
        }
        return $vector;
    }
}

if (!function_exists('cosine_similarity')) {
    function cosine_similarity(array $a, array $b): float
    {
        $dot = 0.0;
        $norm_a = 0.0;
        $norm_b = 0.0;
        $count = min(count($a), count($b));
        for ($i = 0; $i < $count; $i++) {
            $dot += $a[$i] * $b[$i];
            $norm_a += $a[$i] * $a[$i];
            $norm_b += $b[$i] * $b[$i];
        }
        if ($norm_a == 0.0 || $norm_b == 0.0) {
            return 0.0;
        }
        return $dot / (sqrt($norm_a) * sqrt($norm_b));
    }
}

if (!function_exists('build_new_available_rooms')) {
    function build_new_available_rooms(array $available_rooms, array $active_rooms, array $exclude_ids, int $limit): array
    {
        $active_property_ids = [];
        $active_landlord_ids = [];
        foreach ($active_rooms as $room) {
            if (isset($room['property_id'])) {
                $active_property_ids[(int)$room['property_id']] = true;
            }
            if (isset($room['property_manager_id'])) {
                $active_landlord_ids[(int)$room['property_manager_id']] = true;
            }
        }

        $priority = [];
        $others = [];
        foreach ($available_rooms as $room) {
            $room_id = (int)$room['room_id'];
            if (isset($exclude_ids[$room_id])) {
                continue;
            }
            $same_property = isset($active_property_ids[(int)$room['property_id']]);
            $same_landlord = isset($active_landlord_ids[(int)$room['property_manager_id']]);
            if ($same_property || $same_landlord) {
                $priority[] = $room;
            } else {
                $others[] = $room;
            }
        }

        $sort_by_date_desc = function (array &$rooms): void {
            usort($rooms, function ($a, $b) {
                $a_time = isset($a['room_created_at']) ? strtotime($a['room_created_at']) : 0;
                $b_time = isset($b['room_created_at']) ? strtotime($b['room_created_at']) : 0;
                return $b_time <=> $a_time;
            });
        };

        $sort_by_date_desc($priority);
        $sort_by_date_desc($others);

        $merged = array_merge($priority, $others);
        return array_slice($merged, 0, $limit);
    }
}

if (!function_exists('get_tenant_recommendations')) {
    function get_tenant_recommendations(mysqli $mysqli, int $tenant_id, int $limit = 8, int $fallback_limit = 8): array
    {
        $active_rooms = [];
        $active_sql = "SELECT rm.room_id, rm.room_title, rm.room_image, rm.room_rent_amount, rm.room_availability,
                rm.property_id, rm.room_created_at, rm.room_updated_at,
                ps.property_name, ps.property_location, ps.property_description, ps.property_manager_id,
                us.user_name AS landlord_name
            FROM rental_agreements ra
            INNER JOIN rooms rm ON ra.room_id = rm.room_id
            INNER JOIN properties ps ON rm.property_id = ps.property_id
            INNER JOIN users us ON ps.property_manager_id = us.user_id
            WHERE ra.tenant_id = ? AND ra.agreement_status = 'Active'";

        if ($stmt = $mysqli->prepare($active_sql)) {
            $stmt->bind_param('i', $tenant_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $active_rooms[] = $row;
            }
            $stmt->close();
        }

        $available_rooms = [];
        $available_sql = "SELECT rm.room_id, rm.room_title, rm.room_image, rm.room_rent_amount, rm.room_availability,
                rm.property_id, rm.room_created_at, rm.room_updated_at,
                ps.property_name, ps.property_location, ps.property_description, ps.property_manager_id,
                us.user_name AS landlord_name
            FROM rooms rm
            INNER JOIN properties ps ON rm.property_id = ps.property_id
            INNER JOIN users us ON ps.property_manager_id = us.user_id
            WHERE rm.room_availability = 'Available'";

        if ($stmt = $mysqli->prepare($available_sql)) {
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $available_rooms[] = $row;
            }
            $stmt->close();
        }

        if (empty($available_rooms)) {
            return ['recommended' => [], 'new_available' => []];
        }

        if (empty($active_rooms)) {
            $new_available = build_new_available_rooms($available_rooms, [], [], $fallback_limit);
            return ['recommended' => [], 'new_available' => $new_available];
        }

        $all_rooms = array_merge($active_rooms, $available_rooms);
        $max_rent = 0.0;
        foreach ($all_rooms as $room) {
            $rent = isset($room['room_rent_amount']) ? (float)$room['room_rent_amount'] : 0.0;
            if ($rent > $max_rent) {
                $max_rent = $rent;
            }
        }

        $vocab_index = build_vocab_index($all_rooms);

        $active_vectors = [];
        foreach ($active_rooms as $room) {
            $active_vectors[] = room_vector($room, $vocab_index, $max_rent);
        }

        $scored = [];
        foreach ($available_rooms as $room) {
            $vector = room_vector($room, $vocab_index, $max_rent);
            $best_score = 0.0;
            foreach ($active_vectors as $idx => $active_vector) {
                $score = cosine_similarity($vector, $active_vector);

                if ((int)$room['property_id'] === (int)$active_rooms[$idx]['property_id']) {
                    $score += 0.15;
                }
                if ((int)$room['property_manager_id'] === (int)$active_rooms[$idx]['property_manager_id']) {
                    $score += 0.10;
                }
                if ($score > $best_score) {
                    $best_score = $score;
                }
            }
            $room['similarity_score'] = min(1.0, $best_score);
            $scored[] = $room;
        }

        usort($scored, function ($a, $b) {
            return $b['similarity_score'] <=> $a['similarity_score'];
        });

        $recommended = array_slice($scored, 0, $limit);
        $exclude_ids = [];
        foreach ($recommended as $room) {
            $exclude_ids[(int)$room['room_id']] = true;
        }
        $new_available = build_new_available_rooms($available_rooms, $active_rooms, $exclude_ids, $fallback_limit);

        return ['recommended' => $recommended, 'new_available' => $new_available];
    }
}
