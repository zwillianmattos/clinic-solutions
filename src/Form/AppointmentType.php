<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;
class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('beginAt', DateTimeType::class, [
                'label' => 'Inicio',
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('endAt', DateTimeType::class, [
                'label' => 'Fim',
                'required' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
        ;

        $builder->get('beginAt')
            ->addModelTransformer(new CallbackTransformer(
                function ($value) {
                    if(!$value) {
                        return new \DateTime('now');
                    }
                    return $value;
                },
                function ($value) {
                    return $value;
                }
            ))
        ;
        $builder->get('endAt')
            ->addModelTransformer(new CallbackTransformer(
                function ($value) {
                    if(!$value) {
                        return new \DateTime('now +45 minutes');
                    }
                    return $value;
                },
                function ($value) {
                    return $value;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
