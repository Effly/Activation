<?php

namespace App\Form\Type;

use App\Form\Custom\InsuredBirthDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class PersonalDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('insurerFirstName', TextType::class, [
                'label' => 'Фамилия страхователя',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Фамилия не должна быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^[\p{Cyrillic}\s\-]+$/u',
                        'message' => 'Фамилия должна содержать только русские буквы, пробелы и тире',
                    ]),
                    new Regex([
                        'pattern' => '/^\p{Lu}/u',
                        'message' => 'Первая буква фамилии должна быть большой',
                    ]),
                ],
            ])
            ->add('insurerLastName', TextType::class, [
                'label' => 'Имя страхователя',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Имя не должна быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^[\p{Cyrillic}\s\-]+$/u',
                        'message' => 'Имя должна содержать только русские буквы, пробелы и тире',
                    ]),
                    new Regex([
                        'pattern' => '/^\p{Lu}/u',
                        'message' => 'Первая буква Имя должна быть большой',
                    ]),
                ],
            ])
            ->add('insurerPatronymic', TextType::class, [
                'label' => 'Отчество страхователя',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Отчество не должно быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^[\p{Cyrillic}\s\-]+$/u',
                        'message' => 'Отчество должно содержать только русские буквы, пробелы и тире',
                    ]),
                    new Regex([
                        'pattern' => '/^\p{Lu}/u',
                        'message' => 'Первая буква Отчество должно быть большой',
                    ]),
                ],
            ])
            ->add('insurerBirthDate', DateType::class, [
                'label' => 'Дата рождения страхователя',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Дата рождения не должно быть пустой',
                    ]),
                ],
            ])
            ->add('passportSeries', NumberType::class, [
                'label' => 'Серия паспорта',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Серия паспорта не должна быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{4}$/',
                        'message' => 'Серия паспорта должна содержать 4 цифры',
                    ]),
                ],
            ])
            ->add('passportNumber', NumberType::class, [
                'label' => 'Номер паспорта',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Номер паспорта не должен быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{6}$/',
                        'message' => 'Номер паспорта должен содержать 6 цифры',
                    ]),
                ],
            ])
            ->add('passportIssueDate', DateType::class, [
                'label' => 'Дата выдачи паспорта',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Дата выдачи не должен быть пустой',
                    ]),
                ],
            ])
            ->add('passportIssuingAuthority', TextType::class, [
                'label' => 'Код подразделения',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Код подразделения не должен быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{3}-\d{3}$/',
                        'message' => 'Код подразделения содержать только цифры и дефис',
                    ]),
                ],
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Номер телефона',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Код подразделения не должен быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^\+7\d{10}$/',
                        'message' => 'Номер телефона должен соответствовать формату +7, за которым следует 10 цифр',
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('insuredFirstName', TextType::class, [
                'label' => 'Фамилия застрахованного',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Фамилия застрахованного не должна быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^[\p{Cyrillic}\s\-]+$/u',
                        'message' => 'Фамилия застрахованного должна содержать только русские буквы, пробелы и тире',
                    ]),
                    new Regex([
                        'pattern' => '/^\p{Lu}/u',
                        'message' => 'Первая буква фамилии застрахованного должна быть большой',
                    ]),
                ],
            ])
            ->add('insuredLastName', TextType::class, [
                'label' => 'Имя застрахованного',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Имя застрахованного не должна быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^[\p{Cyrillic}\s\-]+$/u',
                        'message' => 'Имя застрахованного должна содержать только русские буквы, пробелы и тире',
                    ]),
                    new Regex([
                        'pattern' => '/^\p{Lu}/u',
                        'message' => 'Первая буква имя застрахованного должна быть большой',
                    ]),
                ],
            ])
            ->add('insuredPatronymic', TextType::class, [
                'label' => 'Отчество застрахованного',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Отчество застрахованного не должна быть пустой',
                    ]),
                    new Regex([
                        'pattern' => '/^[\p{Cyrillic}\s\-]+$/u',
                        'message' => 'Отчество застрахованного должна содержать только русские буквы, пробелы и тире',
                    ]),
                    new Regex([
                        'pattern' => '/^\p{Lu}/u',
                        'message' => 'Первая буква имя застрахованного должна быть большой',
                    ]),
                ],
            ])
            ->add('insuredBirthDate', DateType::class, [
                'label' => 'Дата рождения застрахованного',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Дата рождения застрахованного не должна быть пустой',
                    ]),
                    new InsuredBirthDate(),
                ],
            ])
            ->add('insuredGender', ChoiceType::class, [
                'label' => 'Пол',
                'choices' => [
                    'Мужской' => 'male',
                    'Женский' => 'female',
                ],
                'placeholder' => 'Выберите пол',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пол застрахованного не должен быть пустой',
                    ]),
                ],
            ]);
    }
}