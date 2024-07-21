<?php

namespace App\Validator;

class DateValidator
{
    private $minDate;
    private $maxDate;

    public function __construct()
    {
        $this->minDate = new \DateTime('2023-01-01');
        $this->maxDate = new \DateTime();
    }

    public function validate(\DateTime $date): bool
    {
        return $date >= $this->minDate && $date <= $this->maxDate;
    }

    public function getMinDate(): \DateTime
    {
        return $this->minDate;
    }

    public function getMaxDate(): \DateTime
    {
        return $this->maxDate;
    }
}