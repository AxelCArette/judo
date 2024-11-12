<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class AlbumCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name')->setLabel('Nom de l\'album'),
            TextEditorField::new('description')->setLabel('Description de l\'album'),
            DateField::new('createdAt')
                ->setLabel('Date de création')
                ->setFormTypeOptions(['disabled' => true]), // Optionnel, pour afficher uniquement
            BooleanField::new('Publier')->setLabel('Publié ?'), // Nouveau champ pour gérer la publication
        ];
    }
}
