<?php

namespace common\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    public static function fillToMultiply(array $array, $multiply, $newValue = null)
    {
        $count = count($array);
        $remainder = $count % $multiply;
        for ($i = $multiply ; $i >= $remainder; $i--) {
            $array[] = $newValue;
        }

        return $array;
    }
}
