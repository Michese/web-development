<?php

namespace App\Controller\Admin;

use App\Entity\NewItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NewItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewItem::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextareaField::new('description'),
            TextEditorField::new('text'),
            DateTimeField::new('createdAt'),
            DateTimeField::new('deletedAt'),
            IntegerField::new('views'),
        ];
    }
}
