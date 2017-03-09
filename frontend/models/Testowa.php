<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testowa".
 *
 * @property integer $id
 * @property string $nazwa
 * @property string $adres
 * @property integer $status
 */
class Testowa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testowa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nazwa', 'adres', 'status'], 'required'],
            [['status'], 'integer'],
            [['nazwa'], 'string', 'max' => 200],
            [['adres'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nazwa' => 'Nazwa',
            'adres' => 'Adres',
            'status' => 'Status',
        ];
    }
}
