
INSERT INTO "role" ("id", "name", "created_at", "updated_at", "can_admin") VALUES
(1, 'Admin', NOW(), NULL, 1),
(2, 'User', NOW(), NULL, 0);


INSERT INTO "user" ("id", "role_id", "status", "email", "username", "password", "auth_key", "access_token", "logged_in_ip", "logged_in_at", "created_ip", "created_at", "updated_at", "banned_at", "banned_reason") VALUES
(1, 1, 1, 'me@example.com', 'admin', '$2y$13$dyVw4WkZGkABf2UrGWrhHO4ZmVBv.K4puhOL59Y9jQhIdj63TlV.O', 'sB-taQ_hcmvBecCmIN0df3FptS9nabDc', 'FggrSfeqersuWKrKDeKWBQ0RuPEW1vC2', '127.0.0.1', NOW(), NULL, NOW(), NULL, NULL, NULL);

INSERT INTO "profile" ("id", "user_id", "created_at", "updated_at", "full_name") VALUES
(1, 1, NOW(), NOW(), 'Joe Sixpack');

