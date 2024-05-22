<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateUserSettingTable1 implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE user_setting (
                entryID INT PRIMARY KEY,
                userID INT,
                FOREIGN KEY (userID) REFERENCES user(userID),
                meta_key VARCHAR(255),
                meta_value VARCHAR(255)
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE user_setting"
        ];
    }
}
