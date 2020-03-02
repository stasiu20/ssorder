<?php

namespace frontend\modules\apiV1\models\request;

use yii\base\Model;
use \OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="LoginRequest",
 *     description="LoginRequest model",
 *     @OA\Xml(
 *         name="LoginRequest"
 *     )
 * )
 */
class LoginRequest extends Model
{
    /**
     * @OA\Property(
     *     title="userName",
     *     type="string",
     *     description="User name",
     *     example="sonia.kowalska",
     * )
     * @var string|null
     */
    public $userName;

    /**
     * @OA\Property(
     *     title="password",
     *     type="string",
     *     format="password",
     *     description="User password",
     *     example="secretpassword",
     * )
     * @var string|null
     */
    public $password;

    public function rules()
    {
        return [
            [['userName', 'password'], 'required'],
        ];
    }

    public function addFailedLoginError(): void
    {
        $this->addError('userName', \Yii::t('app', 'Niepoprawny login lub hasło.'));
    }
}
