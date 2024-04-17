<?php

namespace Helpers;

class ValidationHelper
{
    public static function integer($value, float $min = -INF, float $max = INF): int
    {
        // PHPには、データを検証する組み込み関数があります。詳細は https://www.php.net/manual/en/filter.filters.validate.php を参照ください。
        $value = filter_var($value, FILTER_VALIDATE_INT, ["min_range" => (int) $min, "max_range" => (int) $max]);

        // 結果がfalseの場合、フィルターは失敗したことになります。
        if ($value === false) throw new \InvalidArgumentException("The provided value is not a valid integer.");

        // 値がすべてのチェックをパスしたら、そのまま返します。
        return $value;
    }

    public static function checkType($value): string
    {
        $typesArray = ["CPU", "SSD", "RAM", "GPU", "Power", "MotherBoard", "Case"];
        if (!in_array($value, $typesArray)) throw new \InvalidArgumentException("The provided type is not valid Types. Types sholud be  [CPU, SSD, RAM, GPU, Power, MotherBoard, Case]");
        else return $value;
    }
}
