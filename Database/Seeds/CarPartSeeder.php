<?php

namespace Database\Seeds;

require_once 'vendor/autoload.php';

use Database\AbstractSeeder;
use Faker\Factory;


class CarPartSeeder extends AbstractSeeder
{
    protected ?string $tableName = "car_part";
    protected array $tableColumns = [
        // [
        //     'data_type' => 'string',
        //     'column_name' => 'id'
        // ],
        [
            'data_type' => 'int',
            'column_name' => 'carID'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'name'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'description'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'price'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'quantityInStock'
        ],
        [
            'data_type' => 'DateTime',
            'column_name' => 'created_at'
        ],
        [
            'data_type' => 'DateTime',
            'column_name' => 'updated_at'
        ]
    ];

    public function createRowData(): array
    {
        $rowData = [];
        $faker = Factory::create();
        $startDate = '-10 years'; // 10年前
        $endDate = 'now'; // 現在

        for ($i = 0; $i < 100000; $i++) {
            $data = [
                $faker->numberBetween(1, 10000),
                $faker->text(30),
                $faker->text(50),
                $faker->randomFloat(2, 0, 1000),
                $faker->randomNumber(1, true)
            ];
            $rowData[] = $data;
        }
        return $rowData;
    }
}
