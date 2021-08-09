<?php

namespace App\Tests\Fixtures;

use App\Entity\Book;
use Doctrine\ORM\EntityManager;

final class BookFixtures
{
    public function load(EntityManager $manager)
    {
        $manager->persist(new Book('To Kill a Mockingbird', 'Harper Lee', ''));
        $manager->persist(new Book('1984', 'George Orwell', ''));
        $manager->persist(new Book('The Great Gatsby', 'F. Scott Fitzgerald', ''));

        $manager->flush();
    }
}
