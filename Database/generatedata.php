<?php

use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

function insertCarQuery(
    string $make,
    string $model,
    int $year,
    string $color,
    float $price,
    float $mileage,
    string $transmission,
    string $engine,
    string $status
): string {
    return sprintf(
        "INSERT INTO CAR (make, model, year, color, price, mileage, transmission, engine, status)
         VALUES('%s', '%s', %d, '%s',%f,%f,'%s','%s','%s');
        ",
        $make,
        $model,
        $year,
        $color,
        $price,
        $mileage,
        $transmission,
        $engine,
        $status
    );
}


function insertPartQuery(
    string $name,
    string $description,
    float $price,
    int $quantityInStock
): string {
    return sprintf(
        "INSERT INTO Part (name, description, price, quantityInStock)
        VALUES ('%s', '%s', %f, %d);",
        $name,
        $description,
        $price,
        $quantityInStock
    );
}


function runQuery(mysqli $mysqli, string $query): void
{
    $result = $mysqli->query($query);
    if ($result == false) {
        throw new Exception("Could not execute query");
    } else {
        echo "Query executed successfully.\n";
    }
}


runQuery($mysqli, insertCarQuery(
    make: 'Toyota',
    model: 'Corolla',
    year: 2020,
    color: 'Blue',
    price: 20000,
    mileage: 1500,
    transmission: 'Automatic',
    engine: 'Gasoline',
    status: 'Available'
));

runQuery($mysqli, insertPartQuery(
    name: 'Brake Pad',
    description: 'High Quality Brake Pad',
    price: 45.99,
    quantityInStock: 100
));

$mysqli->close();
// $car_insert_query = "
//     INSERT INTO Car(make, model, year, color, milleage, transmission, engine, status)
//     VALUES 
//     ('Toyota', 'Corolla', 2020, 'Blue', 20000, 1500, 'Automatic', 'Gasoline', 'Available'),
//     ('Honda', 'Civic', 2019, 'Red', 18500, 1200, 'Manual', 'Gasoline', 'Sold');
// ";



// $result  = $mysqli->query($car_insert_query);

// if ($result === false) throw new Error("Could not execute car insertion query.");

// $part_insert_query = "
// INSERT INTO Part (name, description, price, quantityInStock)
//     VALUES ('Brake Pad', 'High Quality Brake Pad', 45.99, 100),
//            ('Oil Filter', 'Long-lasting Oil Filter', 10.99, 200);
// ";


// $result = $mysqli->query($part_insert_query);
// if ($result == false) throw new Error("Could not execute part insertion query.");



// $car_part_insert_query = "
//     INSERT INTO CarPart(carId, partId, quantity)
//     VALUES(1, 1, 4),
//           (1, 2, 1);
//           ";

// $result = $mysqli->query($car_part_insert_query);
// if ($result == false) throw new Error("Could not execute car-part insertion query.");

// echo "Data insertion successful.";

// $mysqli->close();
