<?php

namespace Database\Seeds;

require_once 'vendor/autoload.php';

use Database\AbstractSeeder;
use Faker\Factory;

class ComputerPartsSeeder extends AbstractSeeder
{
    protected ?string $tableName = 'computer_parts';
    protected array $tableColumns = [
        [
            'data_type' => 'string',
            'column_name' => 'name'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'type'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'brand'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'model_number'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'release_date'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'description'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'performance_score'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'market_price'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'rsm'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'power_consumptionw'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'lengthm'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'widthm'
        ],
        [
            'data_type' => 'float',
            'column_name' => 'heightm'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'lifespan'
        ]
    ];

    public function createRowData(): array
    {
        $rowData = [
            [
                'Ryzen 9 5900X',
                'CPU',
                'AMD',
                '100-000000061',
                '2020-11-05',
                'A high-performance 12-core processor.',
                90,
                549.99,
                0.05,
                105.0,
                0.04,
                0.04,
                0.005,
                5
            ],
            [
                'GeForce RTX 3080',
                'GPU',
                'NVIDIA',
                '10G-P5-3897-KR',
                '2020-09-17',
                'A powerful gaming GPU with ray tracing support.',
                93,
                699.99,
                0.04,
                320.0,
                0.285,
                0.112,
                0.05,
                5
            ],
            [
                'Samsung 970 EVO SSD',
                'SSD',
                'Samsung',
                'MZ-V7E500BW',
                '2018-04-24',
                'A fast NVMe M.2 SSD with 500GB storage.',
                88,
                79.99,
                0.02,
                5.7,
                0.08,
                0.022,
                0.0023,
                5
            ],
            [
                'Corsair Vengeance LPX 16GB',
                'RAM',
                'Corsair',
                'CMK16GX4M2B3200C16',
                '2015-08-10',
                'A DDR4 memory kit operating at 3200MHz.',
                85,
                69.99,
                0.03,
                1.2,
                0.137,
                0.03,
                0.007,
                7
            ]
        ];

        $faker = Factory::create();
        $startDate = '-10 years'; // 10年前
        $endDate = 'now'; // 現在

        for ($i = 0; $i < 9999; $i++) {
            $rowData[] = [
                $faker->name,
                $faker->randomElement(["CPU", "SSD", "RAM", "GPU", "Power", "MotherBoard", "Case"]),
                $faker->company(),
                $faker->swiftBicNumber(),
                $faker->dateTimeBetween($startDate, $endDate)->format("Y-m-d"),
                $faker->text(40),
                $faker->numberBetween(1, 100),
                $faker->randomFloat(2, 0, 1000),
                $faker->randomFloat(2, 0, 1),
                $faker->randomFloat(2, 0, 1000),
                $faker->randomFloat(2, 0, 10),
                $faker->randomFloat(2, 0, 10),
                $faker->randomFloat(2, 0, 10),
                $faker->numberBetween(0, 10)
            ];
        }

        return $rowData;
    }
}
