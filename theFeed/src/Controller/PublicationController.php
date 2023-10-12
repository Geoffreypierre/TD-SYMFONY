<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Utilisateur;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use App\Service\FlashMessageHelperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class PublicationController extends AbstractController
{
    #[Route('/', name: 'feed', methods: ["GET", "POST"])]
    public function feed(Request $request, EntityManagerInterface $entityManager, PublicationRepository $publicationRepository, FlashMessageHelperInterface $flashMessageHelper): Response {
        if($request->isMethod('POST')) {
            $this->denyAccessUnlessGranted('ROLE_USER');
        }
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication,
            [
                'method' => 'POST',
                'action' => $this->generateURL('feed')
            ]);

        //Traitement du formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $publication->setAuteur($this->getUser());

            // À ce stade, le formulaire et ses données sont valides
            // L'objet "Exemple" a été mis à jour avec les données, il ne reste plus qu'à le sauvegarder
            $entityManager->persist($publication);
            $entityManager->flush();
            $this->addFlash('success', 'La publication a été enregistrée avec succès.');

            //On redirige vers la page suivante
            return $this->redirectToRoute('feed');
        }
        else {
            $flashMessageHelper->addFormErrorsAsFlash($form);
        }

        return $this->render("publication/feed.html.twig",
            [
                "tab" => $publicationRepository->findAllOrderedByDate(),
                "form" => $form
            ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/feedy/{id}', name: 'deletePublication', options: ["expose" => true], methods: ["DELETE"])]
    public function deletePublication(#[MapEntity] ?Publication $publication, EntityManagerInterface $entityManager): JsonResponse
    {
            if ($publication == null) {
                //Retour JSON 404
                return new JsonResponse(
                    [],
                    404
                );
            }

            if ($publication->getAuteur() !== $this->getUser()) {
                //Retour JSON 403
                return new JsonResponse(
                    [],
                    403
                );
            }

            $entityManager->remove($publication);
            $entityManager->flush();
            //Retour JSON 202
            return new JsonResponse(
                [],
                204
            );
    }

}
