<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\BookSearchCriteria;
use App\Entity\Book;
use App\Form\BookSearchCriteriaType;
use App\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Ce controller contient toutes les pages
 * visible pour un utilisateur du e-commerce.
 */
class FrontendController extends AbstractController
{
    /**
     * Récupérer les 20 premiers livres ordonées par date de création.
     * Ajouter la possibilité de données la page en query string ($request->query->get('page')).
     * 
     * @Route("/", name="app_frontend_home")
     */
    public function home(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);

        $page = (int)$request->query->get('page', 1);

        $books = $repository->findAllOrderedByDate(25, $page);

        return $this->render('frontend/home.html.twig', [
            'books' => $books,
        ]);
    }

    /**
     * Récupérer uniquement 20 résultats max.
     * Ajouter la possiblité d'ordonnées par date de création, par nom et par id.
     * Ajouter la possibilité de rechercher par tranche de prix.
     * 
     * @Route("/rechercher", name="app_frontend_search")
     */
    public function search(Request $request): Response
    {
        $form = $this->createForm(BookSearchCriteriaType::class, new BookSearchCriteria());

        $form->handleRequest($request);

        $criterias = $form->getData();

        $repository = $this->getDoctrine()->getRepository(Book::class);

        $books = $repository->findAllBySearchCriterias($criterias);

        return $this->render('frontend/search.html.twig', [
            'books' => $books,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nouveau-livre", name="app_frontend_newBook")
     */
    public function newBook(Request $request): Response
    {
        $form = $this->createForm(BookType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($book);

            $manager->flush();

            return $this->redirectToRoute('app_frontend_displayBook', [
                'id' => $book->getId(),
            ]);
        }

        return $this->render('frontend/newBook.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/livres/{id}", name="app_frontend_displayBook")
     */
    public function displayBook(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Book::class);

        $book = $repository->find($id);

        return $this->render('frontend/displayBook.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/livres/{id}/modifier", name="app_frontend_modifyBook")
     */
    public function modifyBook(Book $book, Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $book
                ->setName($request->request->get('name'))
                ->setDescription($request->request->get('description'))
                ->setImage($request->request->get('image'))
                ->setPrice((float)$request->request->get('price'));

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($book);

            $manager->flush();

            return $this->redirectToRoute('app_frontend_displayBook', [
                'id' => $book->getId(),
            ]);
        }

        return $this->render('frontend/modifyBook.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/livres/{id}/supprimer", name="app_frontend_deleteBook")
     */
    public function deleteBook(Book $book): Response
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($book);

        $manager->flush();

        return $this->render('frontend/deleteBook.html.twig', [
            'book' => $book,
        ]);
    }
}
