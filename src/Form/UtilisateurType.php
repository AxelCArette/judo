<?php

namespace App\Form;

use App\Entity\Membres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo', FileType::class, [
                'label' => 'Photo de profil',
                'required' => false,
                'mapped' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('grade', ChoiceType::class, [
                'label' => 'Grade',
                'choices' => $this->getGradeColors(),
                'placeholder' => 'Sélectionnez un grade',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membres::class,
        ]);
    }

    private function getGradeColors(): array
    {
        return [
            'Découverte'=> 'Découverte',
            'Blanc' => 'Blanc',
            'Jaune' => 'Jaune',
            'Jaune orange'=>'Jaune Orange',
            'Orange' => 'Orange',
            'Orange Verte' => 'Orange Verte',
            'Verte' => 'Verte',
            'Verte bleu'=>'Verte bleu',
            'Bleu'=>'Bleu',
            'Bleue Marron'=> 'Bleu Marron',
            'Marron'=>'Marron',
            'Noire 1er dan'=> 'Noire 1er dan',
            'Noire 2éme dan'=> 'Noire 2éme dan',
            'Noire 3éme dan'=> 'Noire 3éme dan',
            'Noire 4éme dan'=> 'Noire 4éme dan',
            'Noire 5éme dan'=> 'Noire 5éme dan',
            'Noire 6éme dan'=> 'Noire 6éme dan',
        ];
    }
}
