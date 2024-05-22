<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateTagTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE tag(
                tagID INT PRIMARY KEY,
                tagName VARCHAR(255)
            )
            "
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE tag"
        ];
    }
}