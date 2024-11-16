<?php

// src/Form/RessourceType.php

namespace App\Form;

use App\Entity\Ressource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RessourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('text', TextareaType::class, ['required' => false])
            ->add('lien', TextType::class, ['required' => false])
            ->add('type', TextType::class, ['required' => false])
            ->add('grade', ChoiceType::class, [
                'choices' => [
                    'Découverte'=> 'Découverte',
                    'Blanc' => 'Blanc',
                    'Jaune' => 'Jaune',
                    'Jaune Orange'=>'Jaune Orange',
                    'Orange' => 'Orange',
                    'Orange Verte' => 'Orange Verte',
                    'Verte' => 'Verte',
                    'Verte Bleu'=>'Verte Bleu',
                    'Bleu'=>'Bleu',
                    'Bleu Marron'=> 'Bleu Marron',
                    'Marron'=>'Marron',
                    'Noire 1er dan'=> 'Noire 1er dan',
                    'Noire 2éme dan'=> 'Noire 2éme dan',
                    'Noire 3éme dan'=> 'Noire 3éme dan',
                    'Noire 4éme dan'=> 'Noire 4éme dan',
                    'Noire 5éme dan'=> 'Noire 5éme dan',
                    'Noire 6éme dan'=> 'Noire 6éme dan',
                ],
                'required' => false,
                'help' => 'Sélectionnez le grade correspondant à votre niveau',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
        ]);
    }
}
