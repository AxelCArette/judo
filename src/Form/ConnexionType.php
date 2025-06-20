<?php
// src/Form/ConnexionType.php
namespace App\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConnexionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Nom des champs ajustés pour correspondre aux paramètres attendus par Symfony
        $builder
            ->add('_username', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'Mot de passe',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Se connecter',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->add('honeypot', TextType::class, [
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'hidden', // Classe pour cacher le champ
                    'autocomplete' => 'off', // Empêcher l'autocomplétion
                ],
                'label' => false, // Pas de label visible
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
