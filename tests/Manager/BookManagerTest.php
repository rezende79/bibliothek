<?php

declare(strict_types=1);

namespace App\Tests\Manager;


use App\Entity\Book;
use App\Manager\BookManager;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BookManagerTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }

    public function test_if_create_new_book()
    {
        $bookManager = new BookManager($this->entityManager);

        $bookManager->create(new Book(
            'Title',
            'Author',
            'Description'
        ));

        /**
         * @var Book $book
         */
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['title' => 'Title']);

        $this->assertEquals('Author', $book->getAuthor());
        $this->assertEquals('Description', $book->getDescription());
    }

    public function test_if_update_a_book()
    {
        $bookManager = new BookManager($this->entityManager);

        $bookManager->create(new Book(
            'Title',
            'Author',
            'Description'
        ));

        /**
         * @var Book $book
         */
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['title' => 'Title']);

        $book->setTitle('New Title');
        $book->setAuthor('New Author');
        $book->setDescription('New Description');

        $bookManager->update($book);

        $this->assertEquals('New Title', $book->getTitle());
        $this->assertEquals('New Author', $book->getAuthor());
        $this->assertEquals('New Description', $book->getDescription());
    }

    public function test_if_delete_a_book()
    {
        $bookManager = new BookManager($this->entityManager);

        $bookManager->create(new Book(
            'Title',
            'Author',
            'Description'
        ));

        /**
         * @var Book $book
         */
        $book = $this->entityManager->getRepository(Book::class)->findOneBy(['title' => 'Title']);

        $bookManager->delete($book);

        $this->assertNull($this->entityManager->getRepository(Book::class)->findOneBy(['title' => 'Title']));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}