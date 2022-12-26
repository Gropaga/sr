<?php

declare(strict_types=1);

namespace App\SensorReading\Bridge\Controller\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class SensorReadingRequestForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ip', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Add'])
            ->getForm()
        ;
    }
}
