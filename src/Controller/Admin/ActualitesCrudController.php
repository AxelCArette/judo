<?php

namespace App\Controller\Admin;

use App\Entity\Actualites;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ActualitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actualites::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(), // Champ ID uniquement affiché dans la liste
            TextField::new('Titre'), // Champ texte pour le titre
            TextEditorField::new('Contenu'), // Champ texte riche pour le contenu
            DateTimeField::new('datePublication', 'Date de publication')
                ->setFormat('dd/MM/yyyy HH:mm'), // Champ pour la date de publication avec format personnalisé
            ImageField::new('image')
                ->setBasePath('uploads/images') // Chemin public pour afficher les images
                ->setUploadDir('public/asset/img/imgactualite') // Chemin du répertoire de stockage côté serveur
                ->setUploadedFileNamePattern('[randomhash].[extension]') // Génère des noms de fichiers uniques
                ->setRequired(false), // Rend l'image optionnelle
            BooleanField::new('publier', 'Publier ?'), // Champ booléen pour publier ou non
        ];
    }
}
