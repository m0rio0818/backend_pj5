CREATE TABLE IF NOT EXISTS  post_like ( 
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id),
    post_id INT,
    FOREIGN KEY (post_id) REFERENCES post(post_id),
    PRIMARY KEY (user_id, post_id)
)