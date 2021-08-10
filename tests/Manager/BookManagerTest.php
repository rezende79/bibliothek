<?php

declare(strict_types=1);

namespace App\Tests\Manager;


use App\Entity\Book;
use App\Manager\BookManager;
use App\Tests\BaseKernelTestCase;

final class BookManagerTest extends BaseKernelTestCase
{
    public function test_if_create_new_book()
    {
        $bookManager = new BookManager($this->getEntityManager());

        $bookManager->create(new Book(
            'Title',
            'Author',
            'Description'
        ));

        /** @var Book $book */
        $book = $this->getEntityManager()->getRepository(Book::class)->findOneBy(['title' => 'Title']);

        $this->assertEquals('Author', $book->getAuthor());
        $this->assertEquals('Description', $book->getDescription());
    }

    public function test_if_update_a_book()
    {
        $bookManager = new BookManager($this->getEntityManager());

        $bookManager->create(new Book(
            'Title',
            'Author',
            'Description'
        ));

        /** @var Book $book */
        $book = $this->getEntityManager()->getRepository(Book::class)->findOneBy(['title' => 'Title']);

        $bookUpdated = new Book('New Title','New Author','New Description');

        $bookManager->update($book, $bookUpdated);

        $this->assertEquals('New Title', $book->getTitle());
        $this->assertEquals('New Author', $book->getAuthor());
        $this->assertEquals('New Description', $book->getDescription());
    }

    public function test_if_delete_a_book()
    {
        $bookManager = new BookManager($this->getEntityManager());

        $bookManager->create(new Book(
            'Title',
            'Author',
            'Description'
        ));

        /** @var Book $book */
        $book = $this->getEntityManager()->getRepository(Book::class)->findOneBy(['title' => 'Title']);

        $bookManager->delete($book);

        $this->assertNull($this->getEntityManager()->getRepository(Book::class)->findOneBy(['title' => 'Title']));
    }
}