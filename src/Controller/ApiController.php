<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Book;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/books", name="app_api_books")
     */
    public function books(SerializerInterface $serializer): Response
    {
        $books = $this->getDoctrine()->getRepository(Book::class)->findAll();

        $response = new Response($serializer->serialize($books, 'json'));

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
