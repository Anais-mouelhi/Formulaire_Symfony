<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    // Route pour afficher tous les utilisateurs
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        // Récupérer tous les utilisateurs depuis le repository
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    // Route pour créer un nouvel utilisateur
    #[Route('/create', name: 'user_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        // Créer une nouvelle instance de l'entité User
        $user = new User();
        // Créer le formulaire pour créer un utilisateur
        $form = $this->createForm(UserType::class, $user);
        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Persister l'utilisateur dans la base de données
            $em->persist($user);
            // Sauvegarder les changements
            $em->flush();

            // Rediriger vers la page de détails de l'utilisateur nouvellement créé
            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        // Rendre la vue du formulaire de création d'utilisateur
        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour afficher les détails d'un utilisateur
    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        // Rendre la vue des détails de l'utilisateur
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    // Route pour éditer un utilisateur existant
    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $em): Response
    {
        // Créer le formulaire pour éditer l'utilisateur
        $form = $this->createForm(UserType::class, $user);
        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les changements
            $em->flush();

            // Rediriger vers la page de détails de l'utilisateur édité
            return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        // Rendre la vue du formulaire d'édition d'utilisateur
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    // Route pour supprimer un utilisateur
    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $em): Response
    {
        // Vérifier la validité du token CSRF pour la suppression
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            // Supprimer l'utilisateur de la base de données
            $em->remove($user);
            // Sauvegarder les changements
            $em->flush();
        }

        // Rediriger vers la liste des utilisateurs
        return $this->redirectToRoute('user_index');
    }
}
