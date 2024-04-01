CREATE TABLE IF NOT EXISTS post(
    post_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(40),
    content VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id)
)