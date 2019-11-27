<?php

namespace common\models;

use common\behaviors\DateRangeBehavior;
use frontend\helpers\DateRangePickerHelper;
use yii\base\Model;

//todo mmo: Craete search model from Orders
class OrderFilters extends Model
{
    /** @var int */
    public $restaurantId;

    /** @var int */
    public $userId;

    /** @var string */
    public $date;

    /** @var string */
    public $dateFrom;

    /** @var string */
    public $dateTo;

    /** @var int */
    public $status;

    /** @var int */
    public $realizedBy;

    /** @var string */
    public $foodName;

    /** @var int */
    public $foodId;

    public function rules()
    {
        return [
            [['restaurantId', 'date', 'foodName', 'foodId'], 'safe'],
            [['foodId'], 'number', 'integerOnly' => true, 'min' => 1],
            [['date'], 'match', 'pattern' => '/^\d{4}-\d{2}-\d{2}\sdo\s\d{4}-\d{2}-\d{2}$/'],
        ];
    }

    public function behaviors()
    {
        return [
            DateRangePickerHelper::getDefaultBehaviourOptions() + [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date',
                'dateStartAttribute' => 'dateFrom',
                'dateEndAttribute' => 'dateTo',
            ],
        ];
    }
}
