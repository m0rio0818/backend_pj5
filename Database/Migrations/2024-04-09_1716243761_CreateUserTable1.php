<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateUserTable1 implements SchemaMigration
{
    // マイグレーションファイルを生成後、メソッドの処理を記述する
    public function up(): array
    {
        // マイグレーション
        return [
            "CREATE TABLE users (
                id BIGINT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                email_confirmed_at VARCHAR(255),
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )"
        ];
    }

    public function down(): array
    {
        // ロールバック処理を書く
        return [
            "DROP TABLE users"
        ];
    }
}
