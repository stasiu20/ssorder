<?php

namespace common\widgets\grid;

use Yii;
use yii\helpers\Html;

class ActionMaterialIconColumn extends \yii\grid\ActionColumn
{
    protected function initDefaultButtons(): void
    {
        $this->initDefaultButton('view', 'pageview');
        $this->initDefaultButton('update', 'edit');
        $this->initDefaultButton('delete', 'delete', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }

    protected function initDefaultButton($name, $iconName, $additionalOptions = []): void
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', $iconName, ['class' => 'material-icons']);
                return Html::a($icon, $url, $options);
            };
        }
    }
}
