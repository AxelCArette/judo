<?php

namespace App\Controller\Admin;

use App\Entity\Photos;
use App\Entity\Album;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotosCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photos::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            ImageField::new('url')
                ->setUploadDir('public/asset/img/photoChloe')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setBasePath('asset/img/photoChloe')
                ->setRequired(false)
                ->setFormTypeOptions([
                    'multiple' => true,
                ]),
            TextField::new('description'),
            BooleanField::new('isPublished')->setLabel('Publié'),
            AssociationField::new('album')
                ->setLabel('Album') // Label du champ
                ->setFormTypeOptions([
                    'by_reference' => false, // Permet d'associer directement l'entité Album
                    'choice_label' => 'name', // Affiche le nom de l'album dans le formulaire
                ]),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Photos) {
            return;
        }

        // Récupère les fichiers téléchargés
        $files = $entityInstance->getUrl();
        if (is_array($files)) {
            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    // Génère un nom de fichier unique
                    $filename = uniqid() . '.' . $file->guessExtension();
                    
                    // Déplace le fichier dans le répertoire de destination
                    $file->move(
                        $this->getParameter('photos_directory'),
                        $filename
                    );

                    // Associe la photo à un album (l'album est déjà sélectionné dans le formulaire)
                    $album = $entityInstance->getAlbum(); // Récupère l'album sélectionné

                    // Créer un PhotoDetail pour chaque fichier
                    $photoDetail = new PhotoDetail();
                    $photoDetail->setUrl('/asset/img/photoChloe/' . $filename);
                    $photoDetail->setDescription($entityInstance->getDescription());
                    $photoDetail->setPhotos($entityInstance);

                    // Ajouter le PhotoDetail à l'entité Photos
                    $entityManager->persist($photoDetail);

                    // Associer la photo à l'album
                    $entityInstance->setAlbum($album); // Associer l'album à la photo
                }
            }
        }

        // Assure que la date d'ajout est définie si elle n'est pas déjà présente
        if (!$entityInstance->getDateAjout()) {
            $entityInstance->setDateAjout(new \DateTime());
        }

        // Persiste l'entité principale (Photos)
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Appel de persistEntity pour gérer les fichiers et les détails associés
        $this->persistEntity($entityManager, $entityInstance);

        // Finalise la mise à jour en effectuant un flush
        $entityManager->flush();
    }
}
