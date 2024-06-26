CREATE TABLE IF NOT EXISTS post_tag (
    post_id INT,
    FOREIGN KEY (post_id) REFERENCES post(post_id),
    tag_id INT, 
    FOREIGN KEY (tag_id) REFERENCES tag(tag_id),
    PRIMARY KEY (post_id, tag_id)
);