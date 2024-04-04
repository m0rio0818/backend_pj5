<?php

namespace Commands\Programs;


use Database\MySQLWrapper;
use Commands\AbstractCommand;
use Commands\Argument;

class DBWipe extends AbstractCommand
{
    protected static ?string $alias = "db-wipe";


    // 引数を割り当て
    public static function getArguments(): array
    {
        return [
            (new Argument('dump'))->description("DBをdumpファイルを作成し、削除します。dumpファイルから復元できます。")->required(false)->allowAsShort(true),
            (new Argument('restore'))->description("DBを復元します。")->required(false)->allowAsShort(true)
        ];
    }

    public function execute(): int
    {
        $mysqli = new MySQLWrapper();
        $dump = $this->getArgumentValue("dump");
        $restore = $this->getArgumentValue("restore");
        if ($dump) {
            $this->dump();
        } else if ($restore) {
            $this->restore();
        }
        return 0;
    }


    private function drop() : void {
        $mysqli = new MySQLWrapper();
        $dbname = $mysqli->getDatabaseName();
        echo $dbname . PHP_EOL;
        $query = sprintf("DROP DATABASE IF EXISTS %s;", $dbname);
        $mysqli->query($query);
        
        $query = sprintf("CREATE DATABASE %s;", $dbname);
        $mysqli->query($query);

                
        $info =sprintf("DB <%s> が一度削除され、何もない状態で作成しました", $dbname);
        $this->log($info);
    }


    private function dump(): void
    {
        $mysqli = new MySQLWrapper();
        $command = sprintf("mysqldump -u %s -p %s > Database/Backup/backup.sql", $mysqli->getUserName(), $mysqli->getDatabaseName());

        $output = [];
        exec($command, $output, $returnCode);

        // 実行結果を出力
        if ($returnCode === 0) {
            echo "Command executed successfully.\n";
            $this->log("DBをdumpファイルを作成しました");
            self::drop();
        } else {
            echo "Command failed with error code: $returnCode\n";
            $this->log("DBをdumpファイルを作成できませんでした");
        }
    }

    private function restore(): void
    {
        $mysqli = new MySQLWrapper();
        $command = sprintf("mysql -u %s -p %s < Database/Backup/backup.sql", $mysqli->getUserName(), $mysqli->getDatabaseName());

        $output = [];
        exec($command, $output, $returnCode);

        // 実行結果を出力
        if ($returnCode === 0) {
            echo "Command executed successfully.\n";
            $this->log("DBを復元しました");
        } else {
            echo "Command failed with error code: $returnCode\n";
            $this->log("DBをdumpファイルで復元できませんでした");
        }
    }
}
