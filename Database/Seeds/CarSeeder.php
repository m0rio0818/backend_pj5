<?php

namespace Database\Seeds;

require_once 'vendor/autoload.php';

use Database\AbstractSeeder;
use Faker\Factory;


class CarSeeder extends AbstractSeeder
{
    protected ?string $tableName = "car";
    protected array $tableColumns = [
        // [
        //     'data_type' => 'string',
        //     'column_name' => 'id'
        // ],
        [
            'data_type' => 'string',
            'column_name' => 'make'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'model'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'year'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'color'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'price'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'mileage'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'transmission'
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

        for ($i = 0; $i < 10000; $i++) {
            $data = [
                $faker->text(20),
                $faker->text(20),
                (int) $faker->dateTimeBetween($startDate, $endDate)->format("Y"),
                $faker->hexColor(),
                $faker->randomFloat(),
                $faker->randomFloat(),
                $faker->word(),
                $faker->word(),
                $faker->word(),
            ];
            $rowData[] = $data;
        }
        return $rowData;
    }
}
