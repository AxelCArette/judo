<?php

namespace App\Controller\Admin;

use App\Entity\Photos;
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
                ->setLabel('Album') 
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'choice_label' => 'name',
                ]),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Photos) {
            return;
        }
        $files = $entityInstance->getUrl();
        if (is_array($files)) {
            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    $filename = uniqid() . '.' . $file->guessExtension();
                    $file->move(
                        $this->getParameter('photos_directory'),
                        $filename
                    );
                    $album = $entityInstance->getAlbum(); 
                    $photoDetail = new PhotoDetail();
                    $photoDetail->setUrl('/asset/img/photoChloe/' . $filename);
                    $photoDetail->setDescription($entityInstance->getDescription());
                    $photoDetail->setPhotos($entityInstance);
                    $entityManager->persist($photoDetail);
                    $entityInstance->setAlbum($album); 
                }
            }
        }
        if (!$entityInstance->getDateAjout()) {
            $entityInstance->setDateAjout(new \DateTime());
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->persistEntity($entityManager, $entityInstance);
        $entityManager->flush();
    }
}
