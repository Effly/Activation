<?php

namespace App\Form\Request;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewContractRequest extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', null, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 9, 'max' => 9])
                ]
            ])
            ->add('pin', null, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6, 'max' => 6])
                ]
            ]);
    }
}