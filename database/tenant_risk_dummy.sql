-- Dummy data for tenant risk analysis (adjust IDs if needed)

-- Landlord (role_id = 2)
INSERT INTO users (user_id, user_name, user_email, user_phone, user_pic, role_id, user_password)
VALUES
(1001, 'Test Landlord', 'landlord@test.com', '0700000001', '', 2, '$2y$10$TNwhfyAZUoCM8RObT.LxA.softNK88.FTwIsYBRkKZqUtnyXF1upi');

-- Tenants (role_id = 3)
INSERT INTO users (user_id, user_name, user_email, user_phone, user_pic, role_id, user_password)
VALUES
(2001, 'Low Risk Tenant', 'tenant1@test.com', '0700001001', '', 3, '$2y$10$TNwhfyAZUoCM8RObT.LxA.softNK88.FTwIsYBRkKZqUtnyXF1upi'),
(2002, 'Medium Risk Tenant', 'tenant2@test.com', '0700001002', '', 3, '$2y$10$TNwhfyAZUoCM8RObT.LxA.softNK88.FTwIsYBRkKZqUtnyXF1upi'),
(2003, 'High Risk Tenant', 'tenant3@test.com', '0700001003', '', 3, '$2y$10$TNwhfyAZUoCM8RObT.LxA.softNK88.FTwIsYBRkKZqUtnyXF1upi');

-- Property (owned by landlord)
INSERT INTO properties (property_id, property_manager_id, property_name, property_location, property_description)
VALUES
(3001, 1001, 'Test Property', 'Test City', 'Dummy property for risk testing');

-- Rooms
INSERT INTO rooms (room_id, room_title, room_image, room_rent_amount, room_availability, property_id)
VALUES
(4001, 'Room A', '', 2500.00, 'Occupied', 3001),
(4002, 'Room B', '', 2500.00, 'Occupied', 3001),
(4003, 'Room C', '', 2500.00, 'Occupied', 3001);

-- Agreements (Active)
INSERT INTO rental_agreements (agreement_id, agreement_no, tenant_id, room_id, agreement_start_date, agreement_end_date, agreement_status)
VALUES
(5001, 'RA/TEST/001', 2001, 4001, '2025-12-01', '2026-12-01', 'Active'),
(5002, 'RA/TEST/002', 2002, 4002, '2025-12-01', '2026-12-01', 'Active'),
(5003, 'RA/TEST/003', 2003, 4003, '2025-12-01', '2026-12-01', 'Active');

-- Invoices (mix of paid/unpaid/overdue)
INSERT INTO invoices (invoice_id, agreement_id, invoice_date, invoice_due_date, invoice_amount, invoice_status)
VALUES
(6001, 5001, '2026-01-01', '2026-01-05', 2500.00, 'paid'),
(6002, 5002, '2026-01-01', '2026-01-05', 2500.00, 'unpaid'),
(6003, 5002, '2026-02-01', '2026-02-05', 2500.00, 'overdue'),
(6004, 5003, '2026-01-01', '2026-01-05', 2500.00, 'overdue'),
(6005, 5003, '2026-02-01', '2026-02-05', 2500.00, 'overdue'),
(6006, 5003, '2026-02-01', '2026-02-05', 2500.00, 'unpaid');

-- Payments (late/failed/success)
INSERT INTO payments (payment_id, invoice_id, payment_date, payment_amount, payment_method, payment_transaction_id, payment_status)
VALUES
(7001, 6001, '2026-01-10', 2500.00, 'mpesa', 'TXN-LOW-001', 'success'), -- late but paid
(7002, 6002, '2026-01-10', 2500.00, 'mpesa', 'TXN-MED-001', 'failed'), -- failed
(7003, 6003, '2026-02-10', 2500.00, 'mpesa', 'TXN-MED-002', 'success'), -- late
(7004, 6004, '2026-01-20', 2500.00, 'mpesa', 'TXN-HIGH-001', 'failed'), -- failed
(7005, 6005, '2026-02-15', 2500.00, 'mpesa', 'TXN-HIGH-002', 'failed'), -- failed
(7006, 6006, '2026-02-20', 2500.00, 'mpesa', 'TXN-HIGH-003', 'pending'); -- pending

-- Maintenance requests (open)
INSERT INTO maintenance_requests (maintenance_request_id, agreement_id, maintenance_request_description, maintenance_request_status, assigned_to)
VALUES
(8001, 5002, 'Leaky faucet', 'submitted', 1001),
(8002, 5003, 'Broken lock', 'In Progress', 1001),
(8003, 5003, 'Noisy AC', 'submitted', 1001);
