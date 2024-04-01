CREATE TABLE IF NOT EXISTS comment(
    comment_id INT PRIMARY KEY AUTO_INCREMENT,
    commentText VARCHAR(100),
    created_at DATETIME,
    updated_at DATETIME,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    post_id INT,
    FOREIGN KEY (post_id) REFERENCES post(post_id)
)