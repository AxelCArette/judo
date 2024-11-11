<?php
namespace App\Controller\Admin;

use App\Entity\Membres;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField as EasyAdminTextField; // Utilisé pour créer un message custom pour le mot de passe

class MembresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membres::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('adressemail'),
            TextField::new('grade'),
            TextField::new('club'),
        ];
    }
    
}
