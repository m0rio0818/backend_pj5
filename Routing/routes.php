<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;


return [
    'random/part' => function (): HTTPRenderer {
        $part = DatabaseHelper::getRandomComputerPart();

        return new HTMLRenderer('component/random-part', ['part' => $part]);
    },
    'parts' => function (): HTTPRenderer {
        // IDの検証
        $id = ValidationHelper::integer($_GET['id'] ?? null);

        $part = DatabaseHelper::getComputerPartById($id);
        return new HTMLRenderer('component/parts', ['part' => $part]);
    },
    'api/random/part' => function (): HTTPRenderer {
        $part = DatabaseHelper::getRandomComputerPart();
        return new JSONRenderer(['part' => $part]);
    },
    'api/parts' => function () {
        $id = ValidationHelper::integer($_GET['id'] ?? null);
        $part = DatabaseHelper::getComputerPartById($id);
        return new JSONRenderer(['part' => $part]);
    },
    'types' => function () {
        $type =  ValidationHelper::checkType($_GET["type" ?? null]);
        $page = ValidationHelper::integer($_GET['page'] ?? 1);
        $perpage = ValidationHelper::integer($_GET['perpage'] ?? 5);

        $parts = DatabaseHelper::getComputerPartByTypes($type, $page, $perpage);
        return new HTMLRenderer('component/parts_list', ['parts' => $parts]);
    },
    'random/computer' => function () {
        $parts = DatabaseHelper::getBuildRandomComputer();
        return new HTMLRenderer('component/build_computer', ['parts' => $parts]);
    },
    'parts/newest' => function () {

    },
    'parts/performance' => function () {
    }
];
