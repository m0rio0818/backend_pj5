<?php

use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();

$carpart_query = "
    CREATE TABLE IF NOT EXISTS car_parts(
        id INT PRIMARY KEY,
        carID INT,
        FOREIGN KEY (carID) REFERENCES cars(id),
        name VARCHAR(40),
        description VARCHAR(100),
        price FLOAT,
        quantityInStock INT
    );
";


$result = $mysqli->query($carpart_query);

if ($result === false) throw new Exception('Could not execute query.');
else print("Successfully PART all SQL setup queries." . PHP_EOL);
