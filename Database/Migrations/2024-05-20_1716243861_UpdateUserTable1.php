<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class UpdateUserTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "ALTER TABLE users ADD COLUMN company VARCHAR(255)"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "ALTER TABLE users DROP COLUMN company"
        ];
    }
}
