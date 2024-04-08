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
            (new Argument('title'))->description("Open Libraryをtitleで検索します.")->required(false)->allowAsShort(true),
            (new Argument('isbn'))->description("Open Libraryをisbnで検索します.")->required(false)->allowAsShort(true)
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

    private function findIsbn(string $isbn): void
    {
        $mysqli = new MySQLWrapper();
        // $isbn = "0451450523";
        // $isbn = "9780739408254";

        // まずDBに値があるかを確認しにいく。 
        // DBの値がある => 30日以内のものかを確認 => 30日以内 => その値を返す
        //                                   => 30日を超える => 新しく値を更新する。
        // DBの値がない => DBに値を挿入する。

        $key = "book-search-isbn-" . $isbn;
        $findsql = "SELECT * FROM books WHERE id='$key'";
        $result = $mysqli->query($findsql);

        if ($result->num_rows > 0) {
            echo "データが見つかった. 30日以内かを確認します" . PHP_EOL;
            $rows = $result->fetch_assoc();
            $updated_date = $rows["updated_at"];
            if (self::within30Days($updated_date)) {
                // 30日以内かの確認
                $this->log("30日以上経過しているので、再度値を取得、更新します。");
                self::updateData($isbn);
            } else {
                $this->log("最後にDBを更新してから、30日以内ですので、更新はしません");
            }
        } else {
            echo "データが見つからなかったので、データを探し、挿入します。" . PHP_EOL;
            self::insertData($isbn);
        }
    }



    private function findTitle(string $title): void
    {
        // まずDBに値があるかを確認しにいく。 
        // DBの値がある => 30日以内のものかを確認 => 30日以内 => その値を返す
        //                                   => 30日を超える => 新しく値を更新する。
        // DBの値がない => DBに値を挿入する。

        $mysqli = new MySQLWrapper();

        // APIエンドポイントのURL
        $url = "https://openlibrary.org/search.json/?title=$title";

        $response = file_get_contents($url);
        $data = json_decode($response, true);
        $booksInfo = $data["docs"];

        foreach ($booksInfo as $book) {
            // まずisbnを取得
            if (isset($book["isbn"])) {
                $isbns = $book["isbn"];
                $flag = true;
                foreach ($isbns as $isbn) {
                    $key = "book-search-isbn-" . $isbn;
                    $findsql = "SELECT * FROM books WHERE id='$key'";
                    $result = $mysqli->query($findsql);
                    if ($result->num_rows > 0) {
                        echo "書籍がDB上に見つかりました. DBのデータが30日以内チェック";
                        $flag = false;
                        break;
                    }
                }
                if ($flag) {
                    echo "DBにデータがなかったので、挿入します" . PHP_EOL;
                }
            } else {
                echo "ISBNは存在しません" . PHP_EOL;
            }
            // $key = "book-search-isbn-" . ;
            // $title = $mysqli->real_escape_string(json_encode($book["title"][0]));
            // $authors = $mysqli->real_escape_string(json_encode($book["author_name"]));
            // $publishers = $mysqli->real_escape_string(json_encode($book["publisher"]));
            // $isbns = $mysqli->real_escape_string(json_encode($book["isbn"]));
            // $current = date('Y-m-d H:i:s');
            // echo $isbns . PHP_EOL;
        }

        echo $title;
    }


    public function insertDataTitle(string $title): void
    {
        $mysqli = new MySQLWrapper();

        if ($title["numFound"] == 0) {
            $info = sprintf("指定のisbn << %s >> は見つかりませんでした。", $title);
            $this->log($info);
        } else {
            $key = "book-search-isbn-" . $title;
            $bookInfo = $title["docs"][0];
            $title = $mysqli->real_escape_string(json_encode($bookInfo["title"][0]));
            $authors = $mysqli->real_escape_string(json_encode($bookInfo["author_name"]));
            $publishers = $mysqli->real_escape_string(json_encode($bookInfo["publisher"]));
            $isbns = $mysqli->real_escape_string(json_encode($bookInfo["isbn"]));

            $insert_query = "INSERT INTO books (id, title, author, publisher, isbn)
                 VALUES ('$key', '$title', '$authors', '$publishers', '$isbns')";
            $mysqli->query($insert_query);
            echo "挿入が終了しました。" . PHP_EOL;
            $mysqli->close();
        }
    }





    public function within30Days(string $updated_date): bool
    {
        date_default_timezone_set('Asia/Tokyo');
        $updatedTime = strtotime($updated_date);

        $currentTime = time();

        $diffInSeconds =  $currentTime - $updatedTime;
        $diffrentInDays = $diffInSeconds / (60 * 60 * 24);
        echo $diffrentInDays . PHP_EOL;
        return $diffrentInDays >= 30;
    }


    public function updateData(string $isbn): void
    {
        $mysqli = new MySQLWrapper();
        // APIエンドポイント
        $url =  "https://openlibrary.org/search.json/?isbn=$isbn";
        // APIにリクエストを送信して、レスポンスを取得
        $response = file_get_contents($url);
        // レスポンスがJSON形式の場合は、デコードして連想配列に変換
        $data = json_decode($response, true);

        if ($data["numFound"] == 0) {
            $info = sprintf("指定のisbn << %s >> は見つかりませんでした。", $isbn);
            $this->log($info);
        } else {
            $key = "book-search-isbn-" . $isbn;
            $bookInfo = $data["docs"][0];
            $title = $mysqli->real_escape_string(json_encode($bookInfo["title"][0]));
            $authors = $mysqli->real_escape_string(json_encode($bookInfo["author_name"]));
            $publishers = $mysqli->real_escape_string(json_encode($bookInfo["publisher"]));
            $isbns = $mysqli->real_escape_string(json_encode($bookInfo["isbn"]));
            $current = date('Y-m-d H:i:s');

            $insert_query = "
            UPDATE books SET 
            title = '$title',
            author = '$authors',
            publisher = '$publishers',
            isbn = '$isbns',
            updated_at = '$current'
            WHERE id = '$key';
            ";
            $mysqli->query($insert_query);
            echo "更新が終了しました。" . PHP_EOL;
            $mysqli->close();
        }
    }


    public function getQuery(): void
    {
    }


    public function insertData(string $isbn): void
    {
        $mysqli = new MySQLWrapper();
        // APIエンドポイント
        $url =  "https://openlibrary.org/search.json/?isbn=$isbn";

        // APIにリクエストを送信して、レスポンスを取得
        $response = file_get_contents($url);
        // レスポンスがJSON形式の場合は、デコードして連想配列に変換
        $data = json_decode($response, true);

        if ($data["numFound"] == 0) {
            $info = sprintf("指定のisbn << %s >> は見つかりませんでした。", $isbn);
            $this->log($info);
        } else {
            $key = "book-search-isbn-" . $isbn;
            $bookInfo = $data["docs"][0];
            $title = $mysqli->real_escape_string(json_encode($bookInfo["title"][0]));
            $authors = $mysqli->real_escape_string(json_encode($bookInfo["author_name"]));
            $publishers = $mysqli->real_escape_string(json_encode($bookInfo["publisher"]));
            $isbns = $mysqli->real_escape_string(json_encode($bookInfo["isbn"]));

            $insert_query = "INSERT INTO books (id, title, author, publisher, isbn)
                 VALUES ('$key', '$title', '$authors', '$publishers', '$isbns')";
            $mysqli->query($insert_query);
            echo "挿入が終了しました。" . PHP_EOL;
            $mysqli->close();
        }
    }
}
