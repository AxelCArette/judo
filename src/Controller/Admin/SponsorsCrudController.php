<?php

namespace App\Controller\Admin;

use App\Entity\Sponsors;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SponsorsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sponsors::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('nom_sponsors', 'Nom du Sponsor'),
            ImageField::new('logo_url', 'Logo')
                ->setBasePath('/asset/img/imgsponso') // Chemin de lecture pour les images
                ->setUploadDir('public/asset/img/imgsponso/') // Chemin d'upload
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]') // Nom de fichier unique
                ->setRequired(false), // Logo non obligatoire
            TextEditorField::new('description', 'Description'),
            UrlField::new('liensiteweb', 'Lien vers le site web')->setRequired(false),
            BooleanField::new('publier', 'Publier')
        ];
    }
}
