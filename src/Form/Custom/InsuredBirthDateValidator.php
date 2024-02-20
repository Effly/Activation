<?php

namespace App\Form\Custom;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class InsuredBirthDateValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof InsuredBirthDate) {
            throw new UnexpectedTypeException($constraint, InsuredBirthDate::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        // Проверка, что возраст застрахованного не превышает 18 лет
        $currentDate = new \DateTime();
        $birthDate = $value;
        $age = $currentDate->diff($birthDate)->y;

        if ($age > 18) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value->format('Y-m-d'))
                ->addViolation();
        }
    }
}