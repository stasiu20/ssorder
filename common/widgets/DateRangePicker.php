<?php

namespace common\widgets;

use yii\helpers\ArrayHelper;

class DateRangePicker extends \kartik\daterange\DateRangePicker
{
    /**
     * We overwrite base method for one reason. We cant select "today" date.
     * @see https://github.com/kartik-v/yii2-date-range/issues/33
     */
    public function registerAssets()
    {
        parent::registerAssets();
        $id = $this->options['id'];
        $isSingleDatePicker = ArrayHelper::getValue($this->pluginOptions, 'singleDatePicker', false);

        // we currently NOT support singleDatePicker. Maybe also other types?
        if ($isSingleDatePicker) {
            return;
        }

        $js = <<<JS
$('#{$id}').on('apply.daterangepicker', function(ev, picker) {
   $(this).val(picker.startDate.format('{$this->_format}') + '{$this->_separator}' + picker.endDate.format('{$this->_format}'));
}).on('cancel.daterangepicker', function(ev, picker) {
   $(this).val('');
});
JS;
        $view = $this->getView();
        $view->registerJs($js);
    }
}
