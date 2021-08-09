<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Manager\BookManager;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class BookController extends AbstractController
{
    private $entityManager;
    private $bookRepository;
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, BookRepository $bookRepository)
    {
        $this->entityManager = $entityManager;
        $this->bookRepository = $bookRepository;

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/api/book", name="book_list")
     */
    public function bookList(): JsonResponse
    {
        $data = $this->serializer->serialize(
            $this->bookRepository->findAll(),
            'json'
        );

        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Route("/api/book/create", name="book_create", methods={"POST"})
     */
    public function bookCreate(Request $request): JsonResponse
    {
        $book = $this->serializer->deserialize(
            $request->getContent(),
            Book::class,
            'json'
        );

        $bookManager = new BookManager($this->entityManager);
        $bookManager->create($book);

        return new JsonResponse(['message' => 'Book successful created']);
    }
}
