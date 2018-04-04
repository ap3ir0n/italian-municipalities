<?php

namespace App\Form;

use App\Entity\GeographicalDivision;
use App\Entity\MetropolitanCity;
use App\Entity\Municipality;
use App\Entity\Province;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MunicipalityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('number')
            ->add('nameInOtherLanguage')
            ->add('isProvincialCapital')
            ->add('cadastralCode')
            ->add('legalPopulationAt2011')
            ->add('licensePlateCode', TextType::class)
            ->add('province', EntityType::class, [
                'class' => Province::class
            ])
            ->add('metropolitanCity', EntityType::class, [
                'class' => MetropolitanCity::class
            ])
            ->add('geographicalDivision', EntityType::class, [
                'class' => GeographicalDivision::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Municipality::class,
            'allow_extra_fields' => true
        ]);
    }
}
