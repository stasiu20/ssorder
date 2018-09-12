<?php

namespace common\behaviors;

class DateRangeBehavior extends \kartik\daterange\DateRangeBehavior
{
    public function afterValidate($event)
    {
        parent::afterValidate($event);

        if (empty($this->dateStartAttribute) || empty($this->dateEndAttribute)) {
            return;
        }

        //we change behaviour. if startDate and EndDate are the same we change time of endtime to 23:59:59
        //this is rather hack.
        $dateStart = $this->owner->{$this->dateStartAttribute};
        $dateEnd = $this->owner->{$this->dateEndAttribute};

        if (empty($dateStart) || empty($dateEnd)) {
            return;
        }

        if (null !== $dateEnd && $dateEnd === $dateStart) {
            $this->setOwnerAttribute(
                $this->dateEndAttribute,
                $this->dateEndFormat,
                date('Y-m-d H:i:s', strtotime($dateStart) + 86400) // add 24hours
            );
        }
    }
}
