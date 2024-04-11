<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCommentTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE comment(
                commentID INT PRIMARY KEY,
                commentText VARCHAR(255),
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                userID INT,
                FOREIGN KEY (userID) REFERENCES user(userID),
                postID INT,
                FOREIGN KEY (postID) REFERENCES post(postID)
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE comment"
        ];
    }
}
