<?php

namespace App\Controller;

use App\Entity\StringList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkedListController extends AbstractController
{
    #[Route('/', name: 'app_linked_list_show_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $strings = $entityManager->getRepository(StringList::class)->findAll();

        return $this->render('list.html.twig', [
            'strings' => $strings,
        ]);
    }

    #[Route('/add', name: 'app_linked_list_add_string')]
    public function addString(Request $request, EntityManagerInterface $entityManager)
    {
        $string = new StringList();

        $form = $this->createFormBuilder($string)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Add string'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var StringList $string */
            $string = $form->getData();
            $string->setDateCreated(new \DateTime());
            $string->setDateModified(new \DateTime());

            $entityManager->persist($string);
            $entityManager->flush();

            return $this->redirectToRoute('app_linked_list_show_list');
        }

        return $this->render('add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_linked_list_edit_string')]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $string = $entityManager->getRepository(StringList::class)->find($id);

        $form = $this->createFormBuilder($string)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Update string'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var StringList $string */
            $string = $form->getData();
            $string->setDateCreated(new \DateTime());
            $string->setDateModified(new \DateTime());

            $entityManager->persist($string);
            $entityManager->flush();

            return $this->redirectToRoute('app_linked_list_show_list');
        }

        return $this->render('add.html.twig', [
            'form' => $form,
            'entity' => $string,
        ]);
    }
}