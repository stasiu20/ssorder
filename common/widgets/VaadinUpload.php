<?php

namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class VaadinUpload extends Widget
{
    public $target;

    public $accept;

    public $maxFiles;

    public $formDataName;

    public function run()
    {
        $options = [
            'target' => $this->target,
            'accept' => $this->accept,
            'max-files' => $this->maxFiles,
            'form-data-name' => $this->formDataName,
        ];
        return Html::tag('vaadin-upload', '', $options);
    }
}
