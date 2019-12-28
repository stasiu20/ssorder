<?php

namespace common\models;

use Lcobucci\JWT\Token;
use Yii;
use yii\behaviors\AttributeTypecastBehavior;

/**
 * This is the model class for table "access_token".
 *
 * @property string $uuid
 * @property string $token
 * @property int $user_id
 */
class AccessToken extends \yii\redis\ActiveRecord
{
    public static function getByToken(string $token): ?AccessToken
    {
        return self::findOne(['token' => $token]);
    }

    public static function saveTokenForUser(Token $token, User $user): AccessToken
    {
        $tokenAR = new static();
        $tokenAR->uuid = $token->getHeader('jti');
        $tokenAR->token = (string)$token;
        $tokenAR->user_id = $user->id;
        $result = $tokenAR->save();
        if (!$result) {
            throw new \RuntimeException('Cant save access token in database');
        }

        //todo mmo nie kasujemy wszystkiego.
        $pk = static::buildKey(static::primaryKey());
        $key = static::keyPrefix() . ':a:' . $pk;
        static::getDb()->expireat($key, $token->getClaim('exp'));
        return $tokenAR;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                'attributeTypes' => [
                    'user_id' => AttributeTypecastBehavior::TYPE_INTEGER,
                ],
                'typecastAfterValidate' => true,
                'typecastBeforeSave' => true,
                'typecastAfterFind' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['token'], 'string', 'max' => 1000],
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

    public static function primaryKey()
    {
        return ['uuid'];
    }

    public function attributes()
    {
        return ['uuid', 'token', 'user_id'];
    }
}
