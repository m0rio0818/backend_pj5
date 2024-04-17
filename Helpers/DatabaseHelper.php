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
            $ans[] = $row;
        }
        if (!$ans) throw new Exception('Could not find a single part in database');
        return $ans;
    }

    public static function getBuildRandomComputer()
    {
        $db = new MySQLWrapper();
        $partsList = ["CPU", "SSD", "RAM", "GPU", "Power", "MotherBoard", "Case"];

        $ans = [];
        foreach ($partsList as $part) {
            $stmt = $db->prepare("SELECT * FROM computer_parts WHERE type = ?  ORDER BY RAND() LIMIT 1");
            $stmt->bind_param("s", $part);
            $stmt->execute();
            $result = $stmt->get_result();
            $part = $result->fetch_assoc();
            $ans[] = $part;
        }
        if (!$ans) throw new Exception('Could not find a single part in database');
        return $ans;
    }

    public static function getNewestParts(int $page, int $perpage)
    {
        $db = new MySQLWrapper();
        $start = ($page - 1) * $perpage;

        $stmt = $db->prepare("SELECT * FROM computer_parts ORDER BY release_date DESC LIMIT ?, ?");
        $stmt->bind_param("ii", $start, $perpage);
        $stmt->execute();
        $result = $stmt->get_result();
        $ans = [];
        while ($row = $result->fetch_assoc()) {
            $ans[] = $row;
        }
        return $ans;
    }

    public static function getPartByPerformance(string $type, string $order): array
    {
        $db = new MySQLWrapper();
        $order_type = $order == "desc" ? "DESC" : "ASC";
        $sql = "SELECT * FROM computer_parts WHERE type = ? ORDER BY performance_score $order_type LIMIT 50";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $type);
        $stmt->execute();
        $result = $stmt->get_result();
        $ans = [];
        while ($row = $result->fetch_assoc()) {
            $ans[] = $row;
        }
        return $ans;
    }
}
