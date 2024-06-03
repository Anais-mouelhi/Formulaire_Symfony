<?php

// src/Controller/DevisController.php
namespace App\Controller;

use App\Entity\Devis;
use App\Form\DevisType;
use App\Repository\DevisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/devis')]
class DevisController extends AbstractController
{
    // Route pour afficher tous les devis
    #[Route('/', name: 'devis_index')]
    public function index(DevisRepository $devisRepository): Response
    {
        // Récupérer tous les devis depuis le repository
        $devis = $devisRepository->findAll();
        // Rendre la vue 'index' avec les devis
        return $this->render('devis/index.html.twig', [
            'devis' => $devis,
        ]);
    }

    // Route pour créer un nouveau devis
    #[Route('/create', name: 'devis_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        // Créer une nouvelle instance de Devis
        $devis = new Devis();
        // Créer le formulaire pour Devis
        $form = $this->createForm(DevisType::class, $devis);
        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Définir la date de création du devis
            $devis->setCreatedAt(new \DateTime());
            // Persister l'entité Devis dans la base de données
            $em->persist($devis);
            // Sauvegarder les changements
            $em->flush();

            // Rediriger vers la liste des devis
            return $this->redirectToRoute('devis_index');
        }

        // Rendre la vue 'create' avec le formulaire
        return $this->render('devis/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour éditer un devis existant
    #[Route('/edit/{id}', name: 'devis_edit')]
    public function edit(Request $request, Devis $devis, EntityManagerInterface $em): Response
    {
        // Créer le formulaire pour éditer le Devis
        $form = $this->createForm(DevisType::class, $devis);
        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder les changements
            $em->flush();

            // Rediriger vers la liste des devis
            return $this->redirectToRoute('devis_index');
        }

        // Rendre la vue 'edit' avec le formulaire
        return $this->render('devis/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour supprimer un devis
    #[Route('/delete/{id}', name: 'devis_delete', methods: ['POST'])]
    public function delete(Request $request, Devis $devis, EntityManagerInterface $em): Response
    {
        // Vérifier la validité du token CSRF pour la suppression
        if ($this->isCsrfTokenValid('delete' . $devis->getId(), $request->request->get('_token'))) {
            // Supprimer le devis de la base de données
            $em->remove($devis);
            // Sauvegarder les changements
            $em->flush();
        }

        // Rediriger vers la liste des devis
        return $this->redirectToRoute('devis_index');
    }

    // Route pour télécharger le devis en PDF
    #[Route('/devis/{id}/pdf', name: 'devis_pdf')]
    public function downloadPdf(Devis $devis): Response
    {
        // Récupérer le contenu HTML du devis à partir d'un template Twig
        $htmlContent = $this->renderView('devis/pdf.html.twig', ['devis' => $devis]);

        // Options pour DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');

        // Créer une instance de DomPDF
        $dompdf = new Dompdf($options);

        // Charger le contenu HTML dans DomPDF
        $dompdf->loadHtml($htmlContent);

        // Rendre le PDF
        $dompdf->render();

        // Envoyer le PDF en réponse HTTP pour le téléchargement
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="devis.pdf"'
        ]);
    }
}
