<?php

namespace frontend\tests\unit\modules\apiV1\models\request;

use frontend\modules\apiV1\models\request\CreateOrderRequest;

class CreateOrderRequestTest extends \Codeception\Test\Unit
{
    public function testAddErrorForFood(): void
    {
        $model = new CreateOrderRequest();
        $this->assertFalse($model->hasErrors('foodId'));
        $model->addFoodError('foo');
        $this->assertTrue($model->hasErrors('foodId'));
    }
}
