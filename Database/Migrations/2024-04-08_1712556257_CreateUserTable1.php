<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateUserTable1 implements SchemaMigratoin
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [];
    }
}