<?php
namespace App\Controller\Admin;

use App\Entity\Membres;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MembresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membres::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $rolesChoices = [
            'User' => 'ROLE_USER',
            'Admin' => 'ROLE_ADMIN',
        ];

        return [
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('adressemail'),
            TextField::new('grade'),
            TextField::new('club'),
            TextEditorField::new('description'),
            ChoiceField::new('roles')
                ->setChoices($rolesChoices)
                ->allowMultipleChoices()
                ->setHelp('Sélectionner un ou plusieurs rôles')
        ];
    }
}
