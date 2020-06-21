<?php

namespace common\repositories;

use frontend\models\Menu;

class MenuRepository
{
    public function findOne(int $id): ?Menu
    {
        return Menu::findOne($id);
    }
}
