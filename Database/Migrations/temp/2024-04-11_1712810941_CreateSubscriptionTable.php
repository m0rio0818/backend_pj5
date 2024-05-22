<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateSubscriptionTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE subscription(
                subscriptionID INT PRIMARY KEY,
                subscription VARCHAR(255),
                subscription_status VARCHAR(255),
                subscriptionCreatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                subscriptionEndsAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                userID INT,
                FOREIGN KEY (userID) REFERENCES user(userID) ON DELETE CASCADE
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE subscription"
        ];
    }
}
