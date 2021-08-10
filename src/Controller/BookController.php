<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use App\Manager\BookManager;
use App\Repository\BookRepository;
use App\Serializer\GenericSerializer;
use App\Validator\GenericValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class BookController extends AbstractController
{
    private $entityManager;
    private $bookRepository;
    private $validator;
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, BookRepository $bookRepository, GenericValidator $validator, GenericSerializer $serializer)
    {
        $this->entityManager = $entityManager;
        $this->bookRepository = $bookRepository;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/book", name="book_list")
     */
    public function bookList(): JsonResponse
    {
        $data = $this->serializer->serialize($this->bookRepository->findAll());

        return new JsonResponse($data, 200, [], true);
    }

    /**
     * @Route("/api/book/create", name="book_create", methods={"POST"})
     */
    public function bookCreate(Request $request): JsonResponse
    {
        $book = $this->serializer->deserialize($request, Book::class);

        if ($messages = $this->validator->validateEntity($book)) {
            return new JsonResponse(['errors' => $messages], 400);
        }

        $bookManager = new BookManager($this->entityManager);
        $bookManager->create($book);

        return new JsonResponse(['message' => 'Book successful created']);
    }

    /**
     * @Route("/api/book/update/{id}", name="book_update", methods={"POST"})
     */
    public function bookUpdate(int $id, Request $request): JsonResponse
    {
        $book = $this->bookRepository->find($id);

        if (null === $book) {
            return new JsonResponse(['message' => sprintf('Book id %d not found', $id)]);
        }

        $bookUpdated = $this->serializer->deserialize($request, Book::class);

        if ($messages = $this->validator->validateEntity($bookUpdated)) {
            return new JsonResponse(['errors' => $messages], 400);
        }

        $bookManager = new BookManager($this->entityManager);
        $bookManager->update($book, $bookUpdated);

        return new JsonResponse(['message' => sprintf('Book id %d successful updated', $id)]);
    }

    /**
     * @Route("/api/book/delete/{id}", name="book_delete", methods={"GET"})
     */
    public function bookDelete(int $id): JsonResponse
    {
        $book = $this->bookRepository->find($id);

        if (null === $book) {
            return new JsonResponse(['message' => sprintf('Book id %d not found', $id)]);
        }

        $bookManager = new BookManager($this->entityManager);
        $bookManager->delete($book);

        return new JsonResponse(['message' => sprintf('Book id %d successful deleted', $id)]);
    }
}
