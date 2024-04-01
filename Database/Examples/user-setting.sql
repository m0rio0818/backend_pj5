CREATE TABLE IF NOT EXISTS user_setting(
    entry_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    meta_key VARCHAR(50),
    meta_value VARCHAR(255)
)