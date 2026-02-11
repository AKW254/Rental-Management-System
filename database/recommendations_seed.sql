-- Seed data for recommendation testing (uses high IDs to avoid conflicts).
START TRANSACTION;

INSERT INTO users (user_id, user_name, user_email, user_phone, user_pic, role_id, user_password, user_password_reset_code, user_created_at, user_updated_at) VALUES
(9001, 'Test Landlord A', 'landlord9001@example.com', '0700000001', '', 2, '$2y$10$TNwhfyAZUoCM8RObT.LxA.softNK88.FTwIsYBRkKZqUtnyXF1upi', NULL, '2026-02-01 10:00:00', '2026-02-01 10:00:00'),
(9002, 'Test Tenant A', 'tenant9002@example.com', '0700000002', '', 3, '$2y$10$TNwhfyAZUoCM8RObT.LxA.softNK88.FTwIsYBRkKZqUtnyXF1upi', NULL, '2026-02-01 10:05:00', '2026-02-01 10:05:00'),
(9003, 'Test Landlord B', 'landlord9003@example.com', '0700000003', '', 2, '$2y$10$TNwhfyAZUoCM8RObT.LxA.softNK88.FTwIsYBRkKZqUtnyXF1upi', NULL, '2026-02-01 10:08:00', '2026-02-01 10:08:00');

INSERT INTO properties (property_id, property_manager_id, property_name, property_location, property_description, property_created_at) VALUES
(9001, 9001, 'Sunset Court', 'Nairobi West', 'Wifi parking gym security', '2026-02-01 10:10:00'),
(9002, 9001, 'Sunset Annex', 'Nairobi East', 'Wifi parking laundry balcony', '2026-02-01 10:12:00'),
(9003, 9003, 'Hillside View', 'Ruiru', 'Pool garden security clubhouse', '2026-02-01 10:14:00');

INSERT INTO rooms (room_id, room_title, room_image, room_rent_amount, room_availability, property_id, room_created_at, room_updated_at) VALUES
(9001, 'A-101', '', 25000.00, 'Occupied', 9001, '2026-02-01 10:15:00', '2026-02-01 10:15:00'),
(9002, 'A-102', '', 26000.00, 'Available', 9001, '2026-02-10 09:00:00', '2026-02-10 09:00:00'),
(9003, 'B-201', '', 24000.00, 'Available', 9002, '2026-02-09 12:00:00', '2026-02-09 12:00:00'),
(9004, 'C-301', '', 60000.00, 'Available', 9003, '2026-01-25 08:00:00', '2026-01-25 08:00:00');

INSERT INTO rental_agreements (agreement_id, agreement_no, tenant_id, room_id, agreement_start_date, agreement_end_date, agreement_status, agreement_created_at, agreement_updated_at) VALUES
(9001, 'RA/9001/2026', 9002, 9001, '2026-02-01', NULL, 'Active', '2026-02-01 10:20:00', '2026-02-01 10:20:00');

COMMIT;
