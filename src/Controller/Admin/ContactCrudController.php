<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('NomDeLaPersonne', 'Nom')->setColumns('col-md-6'),
            TextField::new('prenomdelapersonne', 'Prénom')->setColumns('col-md-6'),
            EmailField::new('adressemail', 'Email')->setColumns('col-md-6'),
            TelephoneField::new('numerodetelephonedelapersonne', 'Téléphone')->setColumns('col-md-6')->hideOnIndex(),
            TextEditorField::new('textedelapersonne', 'Message')
                ->setColumns('col-md-12')
                ->onlyOnIndex(), 
            TextEditorField::new('textedelapersonne', 'Message complet')->onlyOnDetail(),
        ];
    }
}
