<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\BookKind;
use App\Form\BookKindType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookKindController extends BaseController
{
    /**
     * @Route("/admin/kinds", name="app_admin_bookKind_list")
     */
    public function list(): Response
    {
        return $this->listEntities(BookKind::class, 'admin/bookKind/list.html.twig');
    }

    /**
     * @Route("/admin/kinds/new", name="app_admin_bookKind_new")
     */
    public function new(Request $request): Response
    {
        return $this->createOrModifyEntity(BookKindType::class, $request, 'bookKind');
    }

    /**
     * @Route("/admin/kinds/{id}", name="app_admin_bookKind_modify")
     */
    public function modify(BookKind $kind, Request $request): Response
    {
        return $this->createOrModifyEntity(BookKindType::class, $request, 'bookKind', $kind);
    }

    /**
     * @Route("/admin/kinds/{id}/delete", name="app_admin_bookKind_delete")
     */
    public function delete(BookKind $kind): Response
    {
        return $this->deleteEntity($kind, 'bookKind');
    }
}
