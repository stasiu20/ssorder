<?php

namespace common\widgets\React;

use yii\widgets\InputWidget;

class RatingWidget extends InputWidget
{
    public function run()
    {
        $input = $this->renderInputHtml('numeric');
        echo "<div class='react-wrapper'><div class='react-view-container react-rating'></div><div style=\"display: none;\">$input</div></div>";
    }
}
