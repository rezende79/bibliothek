<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Book;
use App\Tests\BaseKernelTestCase;

final class BookRepositoryTest extends BaseKernelTestCase
{
    public function test_repositoty_works()
    {
        $book = $this->getEntityManager()->getRepository(Book::class)->findOneBy(['title'=>'1984']);

        $books = $this->getEntityManager()->getRepository(Book::class)->findAll();

        $this->assertInstanceOf(Book::class, $book);
        $this->assertCount(3, $books);
    }
}