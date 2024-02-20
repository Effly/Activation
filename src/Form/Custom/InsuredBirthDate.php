<?php

namespace App\Form\Custom;

use Symfony\Component\Validator\Constraints\Date;

class InsuredBirthDate extends Date
{
    public $message = 'Возраст застрахованного не должен превышать 18 лет';
    public $groups = ['YourValidationGroup'];
}