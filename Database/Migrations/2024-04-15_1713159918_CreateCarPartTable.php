<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateCarPartTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE car_part(
                id INT PRIMARY KEY AUTO_INCREMENT,
                carID INT,
                FOREIGN KEY (carID) REFERENCES car(id) ON DELETE CASCADE,
                name VARCHAR(50),
                description VARCHAR(100),
                price FLOAT,
                quantityInStock INT
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE car_part"
        ];
    }
}
