<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

final class BookManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Book $book)
    {
        $this->entityManager->persist($book);
        $this->entityManager->flush();
    }

    public function update(Book $book, Book $bookUpdated)
    {
        $book->setTitle($bookUpdated->getTitle());
        $book->setAuthor($bookUpdated->getAuthor());
        $book->setDescription($bookUpdated->getDescription());

        $this->entityManager->persist($book);
        $this->entityManager->flush();
    }

    public function delete(Book $book)
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }
}
