<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Form\CommanderTyperType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/profile/compte', name: 'app_compte')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $commandes = $user->getCommandes();

        return $this->render('compte/index.html.twig', [
            'commandes' => $commandes
        ]);
    }

    #[Route('/commander/{id}', name: 'app_commander')]
    public function commander(Request $request, Vehicule $vehicule): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $commande = (new Commande())
            ->setMembre($user)
            ->setVehicule($vehicule);


        $form = $this->createForm(CommanderTyperType::class, $commande)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prixTotal = $this->calculateRatePrice(
                $vehicule->getPrixJournalier(),
                $commande->getDateHeureDepart(),
                $commande->getDateHeureFin()
            );

            $commande->setPrixTotal($prixTotal);
            $this->em->persist($commande);
            $user->addCommande($commande);
            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('app_compte');
        }


        return $this->render('compte/commander.html.twig', [
            'form' => $form->createView(),
            'vehicule' => $vehicule
        ]);
    }

    private function calculateRatePrice(
        ?float $prixJournalier,
        ?\DateTimeImmutable $dateHeureDepart,
        ?\DateTimeImmutable $dateHeureFin
    ): float {
        $diffDays = $dateHeureFin->diff($dateHeureDepart);
        return $prixJournalier * $diffDays->days;
    }
}
