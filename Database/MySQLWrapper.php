<?php

namespace Database;

use mysqli;
use Helpers\Settings;


class MySQLWrapper extends mysqli
{
    public function __construct(
        ?string $hostname = "localhost",
        ?string $username = null,
        ?string  $password = null,
        ?int $port = null,
        ?string $socket = null
    ) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $username = $username ?? Settings::env("DATABASE_USER");
        $password = $password ?? Settings::env("DATABASE_USER_PASSWORD");
        $database = $database ?? Settings::env("DATABASE_NAME");

        parent::__construct($hostname, $username, $password, $database, $port, $socket);
    }


    // クエリが問い合わせられるデフォルトのデータベースを取得します。
    // エラーは失敗時にスローされます（つまり、クエリがfalseを返す、または取得された行がない）
    // これらに対処するためにifブロックやcatch文を使用することもできます。
    public function getDatabaseName(): string
    {
        return $this->query("SELECT database() AS the_db")->fetch_row()[0];
    }
}
