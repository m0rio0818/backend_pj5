ALTER TABLE post 
    ADD COLUMN category_id INT,
    ADD FOREIGN KEY (category_id) REFERENCES category(category_id);