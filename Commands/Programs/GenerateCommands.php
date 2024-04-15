<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;

class GenerateCommands extends AbstractCommand
{
    // TODO: エイリアスを設定してください。
    protected static ?string $alias = 'comm-gen';
    protected static bool $requiredCommandValue = true;

    // TODO: 引数を設定してください。
    public static function getArguments(): array
    {
        return [
            (new Argument('command'))->description("Commandをを登録します.")->required(false)->allowAsShort(true),
        ];
    }

    // TODO: 実行コードを記述してください。
    public function execute(): int
    {
        $commandName = $this->getArgumentValue("comm-gen");
        $value = $this->getArgumentValue("command");



        $className = ucfirst($commandName);
        $this->createCommandFile($commandName, $value);
        $this->registryNewCommand($className);
        return 0;
    }



    function registryNewCommand(string $className): void
    {
        $directories = dirname(__FILE__, 2);
        $filename = "registry.php";
        $filePath = $directories . "/" . $filename;
        $currentFile = file_get_contents($filePath);
        echo $currentFile . PHP_EOL;

        echo strpos($currentFile, $className) ? " TRUE " . PHP_EOL : "FALSE" . PHP_EOL;
        if (!strpos($currentFile, $className)) {
            $insertPosition = strpos($currentFile, "];");
            $insertText = "    Commands\Programs\\" . $className . "::class, \n";
            $newContent = substr_replace($currentFile, $insertText, $insertPosition, 0);

            file_put_contents($filePath, $newContent);
        }
    }

    function createCommandFile(string $commandName, string $command): void
    {
        $className = ucfirst($commandName);

        $directories = dirname(__FILE__, 1);
        $fileName = $commandName . ".php";


        $script = sprintf(
            <<<'EOD'
    <?php
    
    namespace Commands\Programs;
    
    use Commands\AbstractCommand;
    use Commands\Argument;
    
    class %s extends AbstractCommand
    {
        // TODO: エイリアスを設定してください。
        protected static ?string $alias = '%s';
    
        // TODO: 引数を設定してください。
        public static function getArguments(): array
        {
            return [];
        }
    
        // TODO: 実行コードを記述してください。
        public function execute(): int
        {
            return 0;
        }
    }
    EOD,
            $className,
            $command
        );


        $filePath = $directories . "/" . $fileName;

        if (file_exists($filePath)) {
            $currentInfo = file_get_contents($filePath);
            if ($currentInfo !== $script) {
                file_put_contents($filePath, $script);
            }
        } else {
            file_put_contents($filePath, $script);
        }
    }
}
