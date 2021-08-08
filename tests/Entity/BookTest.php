<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;

final class BookTest extends TestCase
{
    public function test_if_can_be_constructed()
    {
        $book = new Book(
            'Title',
            'Author',
            'Description'
        );

        $this->assertEquals('Title', $book->getTitle());
        $this->assertEquals('Author', $book->getAuthor());
        $this->assertEquals('Description', $book->getDescription());
    }
}