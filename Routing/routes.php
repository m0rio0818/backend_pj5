<?php

use Helpers\ValidationHelper;
use Models\ComputerPart;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Database\DataAccess\Implementations\ComputerPartDAOImpl;
use Faker\Calculator\Ean;
use Response\Render\JSONRenderer;
use Types\ValueType;

return [
    'random/part' => function (): HTMLRenderer {
        $partDao = new ComputerPartDAOImpl();
        $part = $partDao->getRandom();

        if ($part === null) throw new Exception('No parts are available!');

        return new HTMLRenderer('component/computer-part-card/card', ['part' => $part]);
    },
    'parts' => function (): HTMLRenderer {
        // IDの検証
        $id = ValidationHelper::integer($_GET['id'] ?? null);

        $partDao = new ComputerPartDAOImpl();
        $part = $partDao->getById($id);

        if ($part === null) throw new Exception('Specified part was not found!');

        return new HTMLRenderer('component/computer-part-card/card', ['part' => $part]);
    },
    'update/part' => function (): HTMLRenderer {
        $part = null;
        $partDao = new ComputerPartDAOImpl();
        if (isset($_GET['id'])) {
            $id = ValidationHelper::integer($_GET['id']);
            $part = $partDao->getById($id);
        }
        return new HTMLRenderer('component/computer-part-card/update-computer-part', ['part' => $part]);
    },
    'delete/part' => function (): HTMLRenderer {
        $part = null;
        $partDao = new ComputerPartDAOImpl();
        if (isset($_GET["id"])) {
            $id = ValidationHelper::integer($_GET["id"]);
            $part = $partDao->getById($id);
        }
        return new HTMLRenderer('component/computer-part-card/delete-part', ['part' => $part]);
    },
    "part/id" =>  function (): JSONRenderer {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            throw new Exception('Invalid request method!');
        }

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        if (!$data) {
            throw new Exception('No delete ID provided!');
        }

        $deleteID = ValidationHelper::integer($data["id"]);

        $partDao = new ComputerPartDAOImpl();
        $part = $partDao->getById($deleteID);
        if ($part) {
            return new JSONRenderer(['status' => 'find', 'message' => 'マッチするデータを見つけました']);
        } else return new JSONRenderer(['status' => 'not found', 'message' => 'データが見つかりません. 番号の確認をお願いしす']);
    },
    "delete/part/id" =>  function (): JSONRenderer {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            throw new Exception('Invalid request method!');
        }

        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        if (!$data) {
            throw new Exception('No delete ID provided!');
        }

        $deleteID = ValidationHelper::integer($data["id"]);

        $partDao = new ComputerPartDAOImpl();
        $part = $partDao->delete($deleteID);
        if ($part) {
            return new JSONRenderer(['status' => 'sucess', 'message' => 'データを削除しました']);
        } else return new JSONRenderer(['status' => 'error', 'message' => 'データが見つかりません. 番号の確認をお願いしす']);
    },
    'parts/all' => function (): HTMLRenderer {
        $partDao = new ComputerPartDAOImpl();
        $parts = $partDao->getAll(0, 15);

        return new HTMLRenderer('component/computer-part-card/all-parts', ['parts' => $_POST]);
    },
    'parts/type' => function (): HTMLRenderer {
        $type = $_GET["type"];
        $parts = null;
        $partDao = new ComputerPartDAOImpl();
        if (isset($type)) {
            $totalCount = $partDao->getCountByType($type);
            $parts = $partDao->getAllByType($type, 0, $totalCount);
        }
        if ($parts === null) throw new Exception("NO parts are available!");
        return new HTMLRenderer('component/computer-part-card/all-parts', ['parts' => $parts]);
    },
    'form/update/part' => function (): JSONRenderer {
        try {
            // リクエストメソッドがPOSTかどうかをチェックします
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method!');
            }

            $required_fields = [
                'name' => ValueType::STRING,
                'type' => ValueType::STRING,
                'brand' => ValueType::STRING,
                'modelNumber' => ValueType::STRING,
                'releaseDate' => ValueType::DATE,
                'description' => ValueType::STRING,
                'performanceScore' => ValueType::INT,
                'marketPrice' => ValueType::FLOAT,
                'rsm' => ValueType::FLOAT,
                'powerConsumptionW' => ValueType::FLOAT,
                'lengthM' => ValueType::FLOAT,
                'widthM' => ValueType::FLOAT,
                'heightM' => ValueType::FLOAT,
                'lifespan' => ValueType::INT,
            ];

            $partDao = new ComputerPartDAOImpl();

            // 入力に対する単純なバリデーション。実際のシナリオでは、要件を満たす完全なバリデーションが必要になることがあります。
            $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

            if (isset($_POST['id'])) $validatedData['id'] = ValidationHelper::integer($_POST['id']);

            // 名前付き引数を持つ新しいComputerPartオブジェクトの作成＋アンパッキング
            $part = new ComputerPart(...$validatedData);

            error_log(json_encode($part->toArray(), JSON_PRETTY_PRINT));

            // 新しい部品情報でデータベースの更新を試みます。
            // 別の方法として、createOrUpdateを実行することもできます。
            if (isset($validatedData['id'])) $success = $partDao->update($part);
            else $success = $partDao->create($part);

            if (!$success) {
                throw new Exception('Database update failed!');
            }

            return new JSONRenderer(['status' => 'success', 'message' => 'Part updated successfully']);
        } catch (\InvalidArgumentException $e) {
            error_log($e->getMessage()); // エラーログはPHPのログやstdoutから見ることができます。
            return new JSONRenderer(['status' => 'error', 'message' => 'Invalid data.']);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return new JSONRenderer(['status' => 'error', 'message' => 'An error occurred.']);
        }
    },
];
