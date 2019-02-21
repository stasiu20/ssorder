<?php

namespace common\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    public static function fillToMultiply(array $array, $multiply, $newValue = null)
    {
        $count = count($array);

        $remainder = $count % $multiply;
        if ($remainder != 0) {
            $i = $multiply - $remainder;
            while ($i > 0) {
                $array[] = $newValue;
                $i--;
            }
        }

        return $array;
    }
}
