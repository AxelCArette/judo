<?php

namespace App\Form;

use App\Entity\Membres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('adressemail', EmailType::class)
            ->add('motdepasse', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
                'constraints' => [
                    new Length(['min' => 8]),
                    new Regex([
                        'pattern' => '/[A-Z]/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule.',
                    ]),
                    new Regex([
                        'pattern' => '/[a-z]/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre minuscule.',
                    ]),
                    new Regex([
                        'pattern' => '/[0-9]/',
                        'message' => 'Le mot de passe doit contenir au moins un chiffre.',
                    ])
                ]
            ])
            ->add('grade', ChoiceType::class, [
                'choices' => $this->getGradeColors(),
                'placeholder' => 'Choisir un grade',
            ])
                  // Honeypot
                  ->add('honeypot', TextType::class, [
                    'required' => false,
                    'mapped' => false,
                    'attr' => [
                        'class' => 'hidden', // La classe 'hidden' est définie dans ton fichier CSS
                        'autocomplete' => 'off',
                    ],
                    'label' => false,
                ])
                
            ->add('club', TextType::class)
      
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
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
