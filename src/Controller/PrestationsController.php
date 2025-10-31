<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


final class PrestationsController extends AbstractController
{
    #[Route('/prestations', name: 'app_prestations')]
    public function index(): Response
    {
        return $this->render('prestations/index.html.twig', [
            'controller_name' => 'PrestationsController',
        ]);
    }

    #[Route('/prestations/formations', name: 'app_prestations_formations', methods: ['GET'])]
    public function formations(): Response
    {
        return $this->render('prestations/formation_show.html.twig');
    }


    #[Route('/prestations/formations/chariots', name: 'app_formations_chariots', defaults: ['slug' => 'chariots'], methods: ['GET'])]
    #[Route('/prestations/formations/gerbeurs', name: 'app_formations_gerbeurs', defaults: ['slug' => 'gerbeurs'], methods: ['GET'])]
    #[Route('/prestations/formations/chantier', name: 'app_formations_chantier', defaults: ['slug' => 'chantier'], methods: ['GET'])]
    #[Route('/prestations/formations/nacelles', name: 'app_formations_nacelles', defaults: ['slug' => 'nacelles'], methods: ['GET'])]
    public function formationsShow(string $slug): Response
    {
        $data = [
            'chariots' => [
                'title' => 'Chariots',
                'subtitle' => 'CACES® R489 – Catégories 1A, 1B, 2B, 3, 4, 5',
            ],
            'gerbeurs' => [
                'title' => 'Gerbeurs',
                'subtitle' => 'CACES® R485 – Catégories 1 et 2',
            ],
            'chantier' => [
                'title' => 'Chantier',
                'subtitle' => 'CACES® R482 – Engins de chantier',
            ],
            'nacelles' => [
                'title' => 'Nacelles',
                'subtitle' => 'CACES® R486 – PEMP A, B, C',
            ],
        ];

        return $this->render('prestations/formation_show.html.twig', [
            'slug' => $slug,
            'info' => $data[$slug] ?? ['title' => ucfirst($slug), 'subtitle' => ''],
        ]);
    }

    #[Route('/prestations/formations/chariots', name: 'app_formations_chariots', methods: ['GET'])]
    public function chariots(): Response
    {
        // Intitulés libres : adapte si besoin
        $categories = [
            '1A' => "Transpalettes à conducteur porté / préparateurs au sol",
            '1B' => "Gerbeurs à conducteur porté",
            '2B' => "Chariots à mât rétractable",
            '3'  => "Chariots frontaux ≤ 6 t",
            '4'  => "Chariots frontaux > 6 t",
            '5'  => "Chariots tracteurs / à plateau",
        ];

        return $this->render('prestations/chariots/R489.html.twig', [
            'categories' => $categories,
        ]);
    }

    // Fiche d’une catégorie (ex: 1A, 1B, 2B, 3, 4, 5)
    #[Route(
        '/prestations/formations/chariots/{cat}',
        name: 'app_formations_chariots_cat',
        requirements: ['cat' => '1A|1B|2B|3|4|5'],
        methods: ['GET']
    )]
    public function chariotsShow(string $cat): Response
    {
        // Mini base de contenu (adapte ou branche tes vraies données)
        $labels = [
            '1A' => "Catégorie 1A – Transpalettes / préparateurs au sol",
            '1B' => "Catégorie 1B – Gerbeurs à conducteur porté",
            '2B' => "Catégorie 2B – Chariots à mât rétractable",
            '3'  => "Catégorie 3 – Frontaux ≤ 6 t",
            '4'  => "Catégorie 4 – Frontaux > 6 t",
            '5'  => "Catégorie 5 – Tracteurs / plateaux",
        ];

        return $this->render('prestations/chariots/show.html.twig', [
            'cat'   => $cat,
            'title' => $labels[$cat] ?? "Catégorie $cat",
        ]);
    }


    /* =======================
     * (OPTIONNEL) GERBEURS, CHANTIER, NACELLES — même pattern
     * ======================= */

    // GERBEURS (R485)
    #[Route('/prestations/formations/gerbeurs', name: 'app_formations_gerbeurs', methods: ['GET'])]
    public function gerbeurs(): Response
    {
        $categories = [
            '1' => 'Gerbeur catégorie 1',
            '2' => 'Gerbeur catégorie 2',
        ];
        return $this->render('prestations/gerbeurs/index.html.twig', compact('categories'));
    }

    #[Route('/prestations/formations/gerbeurs/{cat}', name: 'app_formations_gerbeurs_cat', requirements: ['cat' => '1|2'], methods: ['GET'])]
    public function gerbeursShow(string $cat): Response
    {
        return $this->render('prestations/gerbeurs/show.html.twig', [
            'cat' => $cat,
            'title' => "Gerbeurs – Catégorie $cat",
        ]);
    }

    // CHANTIER (R482)
    #[Route('/prestations/formations/chantier', name: 'app_formations_chantier', methods: ['GET'])]
    public function chantier(): Response
    {
        $categories = [
            'A'  => 'Chargeuses / Pelles compactes',
            'F'  => 'Chariots télescopiques',
            'B1' => 'Tracteurs / Petits engins',
            'C1' => 'Niveleuses / Bulldozers',
            'G'  => 'Engins hors-route spécifiques',
        ];
        return $this->render('prestations/chantier/index.html.twig', compact('categories'));
    }

    #[Route('/prestations/formations/chantier/{cat}', name: 'app_formations_chantier_cat', requirements: ['cat' => 'A|F|B1|C1|G'], methods: ['GET'])]
    public function chantierShow(string $cat): Response
    {
        return $this->render('prestations/chantier/show.html.twig', [
            'cat' => $cat,
            'title' => "Chantier – Catégorie $cat",
        ]);
    }

    // NACELLES (R486)
    #[Route('/prestations/formations/nacelles', name: 'app_formations_nacelles', methods: ['GET'])]
    public function nacelles(): Response
    {
        $categories = [
            'A' => 'PEMP type A',
            'B' => 'PEMP type B',
            'C' => 'Conduite hors production',
        ];
        return $this->render('prestations/nacelles/index.html.twig', compact('categories'));
    }

    #[Route('/prestations/formations/nacelles/{cat}', name: 'app_formations_nacelles_cat', requirements: ['cat' => 'A|B|C'], methods: ['GET'])]
    public function nacellesShow(string $cat): Response
    {
        return $this->render('prestations/nacelles/show.html.twig', [
            'cat' => $cat,
            'title' => "Nacelles – Catégorie $cat",
        ]);
    }
}
