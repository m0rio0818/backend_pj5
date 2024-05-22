<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreatePostLikeTabel1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE post_like(
                userID INT,
                FOREIGN KEY (userID) REFERENCES users(id)  ON DELETE CASCADE,
                postID INT,
                FOREIGN KEY (postID) REFERENCES posts(id)  ON DELETE CASCADE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE post_like"
        ];
    }
}
