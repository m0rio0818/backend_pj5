<?php

namespace Commands\Programs;


use Commands\AbstractCommand;
use Commands\Argument;
use Database\MySQLWrapper;
use Error;

class BookSearch extends AbstractCommand
{
    protected static ?string $alias = "book-search";

    // 引数を割り当て
    public static function getArguments(): array
    {
        return [
            (new Argument('title'))->description("Open Libraryをtitleで検索します。")->required(false)->allowAsShort(true),
            (new Argument('isbn'))->description("Open Libraryをisbnで検索します。")->required(false)->allowAsShort(true)
        ];
    }

    public function execute(): int
    {
        $mysqli = new MySQLWrapper();

        $directories = dirname(__FILE__, 3) . "/Database/Examples/";
        $sqlname = "book.sql";
        $sql_path = $directories . $sqlname;
        $sql = file_get_contents($sql_path);
        $result = $mysqli->query($sql);
        if (!$result) {
            throw new \Exception("Failed to retrieve database");
        }


        $title = $this->getArgumentValue("title");
        $isbn = $this->getArgumentValue("isbn");


        if ($title === true) {
            throw new Error("タイトルを引数の後に入力してください\n ex) php console book-search --title xxxxx\n");
            return 0;
        }

        if ($isbn === true) {
            throw new Error("isbnを引数の後に入力してください\n ex) php console book-search --isbn xxxxx\n");
            return 0;
        }

        if ($title) {
            $this->findTitle($title);
        } else if ($isbn) {
            $this->findIsbn($isbn);
        }
        return 1;
    }


    private function findTitle(string $title): void
    {

        $mysqli = new MySQLWrapper();
        // APIエンドポイントのURL
        $url = "https://openlibrary.org/search.json";
        $url .= "?title=" . $title;

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $booksInfo = $data["docs"];

        foreach ($booksInfo as $book) {
            $key = "book-search-isbn";
            $title = $book["title"];
            $authors = $book["author_name"];
            $publishers = $book["publisher"];
            $isbns = $book["isbn"];
            $year = $book["publish_year"];
            echo $title . " : " . var_dump($authors);
        }
        // echo "Title: " . $bookInfo[0]['title'] . "\n";
        // echo "Author: " . $bookInfo['authors'][0]['name'] . "\n";
        // echo "Publish Date: " . $bookInfo['publish_date'] . "\n";
        // echo "TITLE => " . $title . " でbookSearchします" . PHP_EOL;
        // $title = $mysqli->real_escape_string($bookInfo['title']);
        echo $title;
    }


    private function findIsbn(string $isbn): void
    {
        // $isbn = "0451450523";

        // APIエンドポイント
        // $api_url = "https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&format=json&jscmd=data";
        $api_url =  "https://openlibrary.org/search.json/?isbn=$isbn";

        // APIにリクエストを送信して、レスポンスを取得
        $response = file_get_contents($api_url);
        // レスポンスがJSON形式の場合は、デコードして連想配列に変換
        $data = json_decode($response, true);

        if ($data["numFound"] == 0) {
            $info =  sprintf("指定のisbn << %s >> は見つかりませんでした。", $isbn);
            $this->log($info);
        } else {
            $bookInfo = $data["docs"][0];

            $key = "book-search-isbn-" . $isbn;
            $title = $bookInfo["title"];
            $authors = $bookInfo["author_name"];
            $publishers = $bookInfo["publisher"];
            $isbns = $bookInfo["isbn"];
            $years = $bookInfo["publish_year"];
            var_dump($years);
        }
        // echo "ISBN => " . $isbn . " でbookSearchします" . PHP_EOL;
    }
}
