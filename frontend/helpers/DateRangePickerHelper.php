<?php

namespace frontend\helpers;

class DateRangePickerHelper
{
    public static function getDefaultWidgetOptions(): array
    {
        return [
            'locale' => [
                'separator' => ' do ',
                'cancelLabel' => 'Czyść',
                'applyLabel' => 'Zastosuj',
                'format' => 'Y-MM-DD',
            ],
            'opens' => 'left',
        ];
    }

    public static function getDefaultBehaviourOptions(): array
    {
        //the value of seperator must be equal to seperator in widget settings
        return [
            'dateFormat' => 'Y-MM-DD',
            'separator' => ' do ',
            'dateStartFormat' => 'Y-m-d',
            'dateEndFormat' => 'Y-m-d',
        ];
    }
}
