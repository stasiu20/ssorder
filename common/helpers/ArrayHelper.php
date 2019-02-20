<?php

namespace common\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    public static function fillToMultiply(array $array, $multiply, $newValue = null)
    {
        $count = count($array);

        if ($count > $multiply) {
            $remainder = $multiply - ($count % $multiply);
        } elseif ($count < $multiply) {
            $remainder = $multiply % $count;
        } else {
            $remainder = 0;
        }

        if ($remainder != 0) {
            while ($remainder > 0) {
                $array[] = $newValue;
                $remainder--;
            }
        }

        return $array;
    }
}
