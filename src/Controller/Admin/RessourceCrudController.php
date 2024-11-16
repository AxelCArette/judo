<?php

namespace App\Controller\Admin;

use App\Entity\Ressource;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Doctrine\ORM\EntityManagerInterface;

class RessourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ressource::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Ressource) {
            // Si la date/heure n'est pas définie, on la fixe à l'heure actuelle
            if (!$entityInstance->getDatetime()) {
                $entityInstance->setDatetime(new \DateTime());
            }

            // Définir Publier à false si non défini
            if ($entityInstance->isPublier() === null) {
                $entityInstance->setPublier(false);
            }

            parent::persistEntity($entityManager, $entityInstance);
        }
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Ressource) {
            // Vérifier si le champ 'Publier' a changé, et ajuster en conséquence
            if ($entityInstance->isPublier() === null) {
                $entityInstance->setPublier(false);
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextareaField::new('text')->setRequired(false),
            UrlField::new('lien')->setRequired(false),
            ChoiceField::new('grade')
                ->setChoices([
                    'Découverte' => 'Découverte',
                    'Blanc' => 'Blanc',
                    'Jaune' => 'Jaune',
                    'Jaune Orange' => 'Jaune Orange',
                    'Orange' => 'Orange',
                    'Orange Verte' => 'Orange Verte',
                    'Verte' => 'Verte',
                    'Verte Bleu' => 'Verte Bleu',
                    'Bleu' => 'Bleu',
                    'Bleu Marron' => 'Bleu Marron',
                    'Marron' => 'Marron',
                    'Noire 1er dan' => 'Noire 1er dan',
                    'Noire 2éme dan' => 'Noire 2éme dan',
                    'Noire 3éme dan' => 'Noire 3éme dan',
                    'Noire 4éme dan' => 'Noire 4éme dan',
                    'Noire 5éme dan' => 'Noire 5éme dan',
                    'Noire 6éme dan' => 'Noire 6éme dan',
                ])
                ->setRequired(false)
                ->setHelp('Sélectionnez le grade associé à cette ressource'),
            ImageField::new('image')
                ->setBasePath('assets/img/ressource') 
                ->setUploadDir('public/asset/img/ressource') 
                ->setRequired(false)
                ->onlyOnForms(),
            BooleanField::new('Publier')
                ->setHelp('Indique si la ressource est publiée')
                ->setRequired(false),
        ];
    }
}
