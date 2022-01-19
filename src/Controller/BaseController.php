<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * Liste les entités
     */
    protected function listEntities(string $className, string $templateName): Response
    {
        $entities = $this
            ->getDoctrine()
            ->getRepository($className)
            ->findAll();

        return $this->render($templateName, [
            'entities' => $entities,
        ]);
    }

    /**
     * Créer ou afffiche le formulaire d'une nouvelle entité
     */
    protected function createOrModifyEntity(string $formTypeClass, Request $request, string $controllerName, $data = null): Response
    {
        $form = $this->createAndHandleForm($formTypeClass, $request, $data);

        if ($form->isSubmitted() && $form->isValid()) {
            $kind = $form->getData();

            $this->persistAndFlush($kind);

            return $this->redirectToRoute('app_admin_' . $controllerName . '_list');
        }

        $templateName = $data === null ? 'new' : 'modify';

        return $this->render('admin/' . $controllerName . '/' . $templateName . '.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete an entity
     */
    protected function deleteEntity($entity, string $controllerName): Response
    {
        $this->removeAndFlush($entity);

        return $this->render('admin/' . $controllerName . '/delete.html.twig', [
            $controllerName => $entity,
        ]);
    }

    /**
     * Créer un formulaire et gére la requête
     */
    protected function createAndHandleForm(string $formTypeClass, Request $request, $data = null): FormInterface
    {
        $form = $this->createForm($formTypeClass, $data);

        $form->handleRequest($request);

        return $form;
    }

    /**
     * Persit and flush entities
     */
    protected function persistAndFlush($entity)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->persist($entity);

        $manager->flush();
    }

    /**
     * Remove and flush entities
     */
    protected function removeAndFlush($entity)
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($entity);

        $manager->flush();
    }
}
