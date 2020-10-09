<?php

namespace common\tests\unit\transformers;

use Codeception\Test\Unit;
use common\transformers\DictCategoryTransformer;
use frontend\models\Category;

class DictCategoryTransformerTest extends Unit
{
    public function testTransform(): void
    {
        $data = [
            'id' => 25,
            'categoryName' => 'foo',
        ];
        $category = new Category();
        $category->load($data, '');

        $transformer = new DictCategoryTransformer();
        $array = $transformer->transform($category);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);

        $this->assertEquals($category->id, $array['id']);
        $this->assertEquals($category->categoryName, $array['name']);
    }
}
