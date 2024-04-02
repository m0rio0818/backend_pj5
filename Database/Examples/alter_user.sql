ALTER TABLE user
    ADD COLUMN subscription VARCHAR(50),
    ADD COLUMN subscription_status VARCHAR(50),
    ADD COLUMN subscription_created_at DATETIME,
    ADD COLUMN subscription_updated_at DATETIME;