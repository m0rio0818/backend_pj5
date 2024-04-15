<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCarTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE car(
                id INT PRIMARY KEY AUTO_INCREMENT,
                make VARCHAR(50) NOT NULL,
                model VARCHAR(100) NOT NULL,
                year INT,
                color VARCHAR(50),
                price FLOAT,
                mileage FLOAT,
                transmission VARCHAR(255),
                engine VARCHAR(100),
                status VARCHAR(255),
                created_at TIMESTAMP,
                updated_at TIMESTAMP
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE car"
        ];
    }
}
