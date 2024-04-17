<?php

namespace Helpers;

use Database\MySQLWrapper;
use Exception;

class DatabaseHelper
{
    public static function getRandomComputerPart(): array
    {
        $db = new MySQLWrapper();

        $stmt = $db->prepare("SELECT * FROM computer_parts ORDER BY RAND() LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $part = $result->fetch_assoc();

        if (!$part) throw new Exception('Could not find a single part in database');

        return $part;
    }

    public static function getComputerPartById(int $id): array
    {
        $db = new MySQLWrapper();

        $stmt = $db->prepare("SELECT * FROM computer_parts WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $part = $result->fetch_assoc();

        if (!$part) throw new Exception('Could not find a single part in database');

        return $part;
    }


    public static function getComputerPartByTypes(string $types, int $page, int $perpage): array
    {
        $db = new MySQLWrapper();

        $start = ($page - 1) * $perpage;

        $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type =  ? LIMIT ?, ?");
        $stmt->bind_param("sii", $types, $start, $perpage);
        $stmt->execute();

        $ans = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            // echo "Hello world   ";
            // var_dump($row);
            // echo "End world   ";
            $ans[] = $row;
        }
        if (!$ans) throw new Exception('Could not find a single part in database');
        return $ans;
    }
}
