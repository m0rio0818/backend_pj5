<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCommentLikeTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE comment_like(
                userID INT,
                FOREIGN KEY (userID) REFERENCES comment(userID),
                postID INT,
                FOREIGN KEY (commentID) REFERENCES comment(commentID)
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE comment_like"
        ];
    }
}
