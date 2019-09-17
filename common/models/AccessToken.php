<?php

namespace common\models;

use Lcobucci\JWT\Token;
use Yii;

/**
 * This is the model class for table "access_token".
 *
 * @property string $token
 * @property integer $user_id
 */
class AccessToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_token';
    }

    public static function getByToken(string $token): ?AccessToken
    {
        return self::findOne(['token' => $token]);
    }

    public static function saveTokenForUser(Token $token, User $user): AccessToken
    {
        $tokenAR = new static();
        $tokenAR->token = (string)$token;
        $tokenAR->user_id = $user->id;
        $result = $tokenAR->save();
        if (!$result) {
            throw new \RuntimeException('Cant save access token in database');
        }
        return $tokenAR;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'user_id' => 'User ID',
        ];
    }
}
