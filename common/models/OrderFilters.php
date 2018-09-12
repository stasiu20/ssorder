<?php

namespace common\models;

use common\behaviors\DateRangeBehavior;
use frontend\helpers\DateRangePickerHelper;
use yii\base\Model;

//todo mmo: Craete search model from Orders
class OrderFilters extends Model
{
    public $restaurantId;
    public $userId;
    public $date;
    public $dateFrom;
    public $dateTo;
    public $status;
    public $realizedBy;
    public $foodName;

    public function rules()
    {
        return [
            [['restaurantId', 'date', 'foodName'], 'safe'],
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
