CREATE TABLE IF NOT EXISTS comment_like(
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    comment_id INT,
    FOREIGN KEY (comment_id) REFERENCES comment(comment_id),
    PRIMARY KEY(user_id, comment_id)
);