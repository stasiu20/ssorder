<?php

namespace frontend\modules\apiV1\models\request;

use yii\base\Model;

/**
 * @OA\Schema(
 *     title="CreateWebpushRequest",
 *     description="CreateWebpushRequest model",
 *     @OA\Xml(
 *         name="CreateWebpushRequest"
 *     )
 * )
 */
class CreateWebpushRequest extends Model
{
    /**
     * Webpush endpoint
     *
     * @OA\Property(
     *     title="endpoint",
     *     type="string",
     *     format="text",
     *     description="Endpoint URL",
     *     example="http://",
     * )
     * @var string|null
     */
    public $endpoint;

    /**
     * Webpush keys
     *
     * @OA\Property(
     *     title="keys",
     *     type="object",
     *     description="Keys",
     *     @OA\Property (
     *             property="p256dh",
     *             type="string",
     *             description="Key"
     *     ),
     *     @OA\Property (
     *             property="auth",
     *             type="string",
     *             description="Auth"
     *     )
     * )
     * @var array|null
     */
    public $keys;

    public function rules()
    {
        return [
            [['endpoint', 'keys'], 'required'],
            [['endpoint'], 'url', 'validSchemes' => ['https']],
        ];
    }
}
