<?php


namespace Helpers;

use Exception;
use mysqli;
use ReadAndParseEnvException;
/*
    接続の失敗時にエラーを報告し、例外をスローします。データベース接続を初期化する前にこの設定を行ってください。
    テストするには、.env設定で誤った情報を入力します。
*/


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$mysqli = new mysqli(
    "localhost",
    Settings::env("DATABASE_USER"),
    Settings::env("DATABASE_USER_PASSWORD"),
    Settings::env("DATABASE_NAME")
);

$charset = $mysqli->get_charset();


if ($charset === null) throw new Exception("Charset could be read");


printf("%s7s charset : %s.%s", Settings::env("DATABASE_NAME"), $charset->charset, PHP_EOL);


printf(
    "collation: %s.%s",
    $charset->collation,
    PHP_EOL
);

// 接続を閉じるには、closeメソッドを使用します。
$mysqli->close();


class Settings
{
    private const ENV_PATH = ".env";

    public static function env(string $pair): string
    {
        // dirname関数は、指定されたファイルパスの親ディレクトリのパスを返す関数です。
        // この関数には「levels」という整数型のパラメータを設定することができ、これは「いくつ親ディレクトリを遡るか」を指定するものです。
        // デフォルトではこの「levels」は1に設定されており、つまり、ファイルの直接の親ディレクトリのパスを返します。  
        $config = parse_ini_file(dirname(__FILE__, 2) . "/" . self::ENV_PATH);


        if ($config === false) {
            throw new ReadAndParseEnvException();
        }
        return $config[$pair];
    }
}
