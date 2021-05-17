<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customerName', TextType::class)
            ->add('mobile', TextType::class)
            ->add('dateOfArrival', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'MMM d, yyyy, H:mm a',
                'html5' => false
            ])
            ->add('airportName', TextType::class)
            ->add('airportTerminal', TextType::class)
            ->add('airflightNumber', TextType::class);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'csrf_protection' => false
        ]);
    }
}
