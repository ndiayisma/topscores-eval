<?php

namespace App\Controller;

use App\Entity\StreamDemain;
use App\Form\StreamDemainType;
use App\Repository\StreamDemainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/streamdemain')]
class StreamDemainController extends AbstractController
{
    #[Route('/', name: 'app_stream_demain_index', methods: ['GET'])]
    public function index(StreamDemainRepository $streamDemainRepository): Response
    {
        return $this->render('stream_demain/index.html.twig', [
            'stream_demains' => $streamDemainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stream_demain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $streamDemain = new StreamDemain();
        $form = $this->createForm(StreamDemainType::class, $streamDemain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($streamDemain);
            $entityManager->flush();

            return $this->redirectToRoute('app_stream_demain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stream_demain/new.html.twig', [
            'stream_demain' => $streamDemain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stream_demain_show', methods: ['GET'])]
    public function show(StreamDemain $streamDemain): Response
    {
        return $this->render('stream_demain/show.html.twig', [
            'stream_demain' => $streamDemain,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stream_demain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StreamDemain $streamDemain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StreamDemainType::class, $streamDemain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stream_demain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stream_demain/edit.html.twig', [
            'stream_demain' => $streamDemain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stream_demain_delete', methods: ['POST'])]
    public function delete(Request $request, StreamDemain $streamDemain, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$streamDemain->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($streamDemain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stream_demain_index', [], Response::HTTP_SEE_OTHER);
    }
}
