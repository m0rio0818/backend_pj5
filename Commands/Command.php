<?php

namespace Commands;

interface Command
{
    public static function getAlias(): string;
    public static function getArguments(): array;
    public static function getHelp(): string;
    public static function isCommandValueRequired(): bool;

    /** @return bool | string - 値が存在する場合は、値の文字列かパラメータが存在する場合はtrueを返します。
     * 引数が設定されていない場合はfalseを返します。 */
    public function getArgumentValue(string $arg): bool | string;
    public function execute(): int;
}