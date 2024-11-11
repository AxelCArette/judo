<?php
// src/Form/ConnexionType.php
namespace App\Form;

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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
