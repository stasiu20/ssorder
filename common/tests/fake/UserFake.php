<?php

namespace common\tests\fake;

use common\models\User;

class UserFake extends User
{
    public function hasAttribute($name): bool
    {
        // jak wywolywana jest metoda dateProvider PHPUNIT to nie mamy jeszcze skonfigurowanej
        // app Yii dlatego korzystamy z fake, ktory akceptuje kazda nazwe atrybutu (kolumna w bd)
        return true;
    }
}
