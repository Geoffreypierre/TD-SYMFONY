<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use App\Service\FlashMessageHelperInterface;
use App\Service\UtilisateurManager;
use App\Service\UtilisateurManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UtilisateurController extends AbstractController
{

    #[Route('/utilisateurs/{login}/feed', name: 'pagePerso', methods: ["GET"])]
    public function pagePerso(#[MapEntity] ?Utilisateur $utilisateur): Response
    {
        if($utilisateur == null) {
            $this->addFlash('error', 'Utilisateur inexistant !');
            return $this->redirectToRoute('feed');
        }

        return $this->render("utilisateur/page_perso.html.twig",
            [
                "user" => $utilisateur
            ]);
    }


    #[Route('/inscription', name: 'inscription', methods: ["GET", "POST"])]
    public function inscription(Request $request,
                                EntityManagerInterface $entityManager,
                                UtilisateurRepository $utilisateurRepository,
                                FlashMessageHelperInterface $flashMessageHelper,
                                UtilisateurManagerInterface $utilisateurManager,
    ): Response
    {
        if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('feed');
        }

        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur,
            [
                'method' => 'POST',
                'action' => $this->generateURL('inscription')
            ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // À ce stade, le formulaire et ses données sont valides
            // L'objet "Exemple" a été mis à jour avec les données, il ne reste plus qu'à le sauvegarder

            $utilisateurManager->proccessNewUtilisateur(
                $utilisateur,
                $form->get('plainPassword')->getData(),
                $form->get('fichierPhotoProfil')->getData(),
            );

            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur  a été enregistrée avec succès.');

            //On redirige vers la page suivante
            return $this->redirectToRoute('feed');
        }

        $flashMessageHelper->addFormErrorsAsFlash($form);

        return $this->render("utilisateur/inscription.html.twig",
            [
                "form" => $form
            ]);
    }

    #[Route('/connexion', name: 'connexion', methods: ['GET', 'POST'])]
    public function connexion(AuthenticationUtils $authenticationUtils) : Response {
        if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('feed');
        }

        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('utilisateur/connexion.html.twig', [
            'lastUsername' => $lastUsername,
        ]);
    }

    #[Route('/deconnexion', name: 'deconnexion', methods: ['POST'])]
    public function routeDeconnexion(): never
    {
        //Ne sera jamais appelée
        throw new \Exception("Cette route n'est pas censée être appelée. Vérifiez security.yaml");
    }
}
