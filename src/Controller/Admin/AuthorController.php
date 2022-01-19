<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AuthorController extends BaseController
{
    /**
     * @Route("/admin/authors", name="app_admin_author_list")
     */
    public function list(): Response
    {
        return $this->listEntities(Author::class, 'admin/author/list.html.twig');
    }

    /**
     * @Route("/admin/authors/new", name="app_admin_author_new")
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();



        return $this->createOrModifyEntity(AuthorType::class, $request, 'author');
    }

    /**
     * @Route("/admin/authors/{id}", name="app_admin_author_modify")
     */
    public function modify(Author $author, Request $request): Response
    {
        return $this->createOrModifyEntity(AuthorType::class, $request, 'author', $author);
    }

    /**
     * @Route("/admin/authors/{id}/delete", name="app_admin_author_delete")
     */
    public function delete(Author $author): Response
    {
        return $this->deleteEntity($author, 'author');
    }
}
