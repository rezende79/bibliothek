<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->persist(new Book('To Kill a Mockingbird', 'Harper Lee', ''));
        $manager->persist(new Book('1984', 'George Orwell', ''));
        $manager->persist(new Book('The Great Gatsby', 'F. Scott Fitzgerald', ''));

        $manager->flush();
    }
}
