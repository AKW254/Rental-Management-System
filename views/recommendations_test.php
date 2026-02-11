<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/analysis/tenant_recommendations.php';
//Test User ID 9002 has an active agreement with property 9001, managed by landlord 9001. We expect recommendations to include rooms from the same property or landlord, and to show newly available rooms.
$tenant_id = 9002;
//iNVOKE THE FUNCTION
$data = get_tenant_recommendations($mysqli, $tenant_id, 5, 5);

$failures = 0;
function assert_true(bool $condition, string $message, int &$failures): void
{
    if ($condition) {
        echo "PASS: {$message}\n";
    } else {
        echo "FAIL: {$message}\n";
        $failures++;
    }
}

assert_true(is_array($data['recommended']), 'recommended is array', $failures);
assert_true(is_array($data['new_available']), 'new_available is array', $failures);
assert_true(count($data['recommended']) > 0, 'has recommendations', $failures);

$has_same_property_or_landlord = false;
foreach ($data['recommended'] as $room) {
    if ((int)$room['property_id'] === 9001 || (int)$room['property_manager_id'] === 9001) {
        $has_same_property_or_landlord = true;
        break;
    }
}
assert_true($has_same_property_or_landlord, 'recommendations include same property or landlord', $failures);

echo "\nRecommended Rooms:\n";
foreach ($data['recommended'] as $room) {
    $score = isset($room['similarity_score']) ? round((float)$room['similarity_score'], 3) : 0.0;
    echo "- {$room['room_title']} | {$room['property_name']} | score {$score}\n";
}

echo "\nNewly Available Rooms:\n";
foreach ($data['new_available'] as $room) {
    echo "- {$room['room_title']} | {$room['property_name']}\n";
}

if ($failures > 0) {
    echo "\n{$failures} test(s) failed.\n";
    exit(1);
}

echo "\nAll checks passed.\n";
