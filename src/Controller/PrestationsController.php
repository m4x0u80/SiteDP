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
            'title' => $labels[$cat] ?? "CACES® R489 - Catégorie $cat",
        ]);
    }

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
            'title' => "CACES® R485 – Catégorie $cat",
        ]);
    }

    // CHANTIER (R482)
    #[Route('/prestations/formations/chantier', name: 'app_formations_chantier', methods: ['GET'])]
    public function chantier(): Response
    {
        $categories = [
            'A'  => 'Mini-engins (mini-pelles, mini-chargeuses…)',
            'B1' => 'Pelles hydrauliques',
            'C1' => 'Chargeuses sur pneus',
            'F'  => 'Compacteurs',
            'G'  => 'Engins télécommandés / à distance',
        ];
        return $this->render('prestations/chantier/index.html.twig', compact('categories'));
    }

    #[Route('/prestations/formations/chantier/{cat}', name: 'app_formations_chantier_cat', requirements: ['cat' => 'A|B1|C1|F|G'], methods: ['GET'])]
    public function chantierShow(string $cat): Response
    {
        return $this->render('prestations/chantier/show.html.twig', [
            'cat' => $cat,
            'title' => "CACES® R482 – Catégorie $cat",
        ]);
    }

    // NACELLES (R486)
    #[Route('/prestations/formations/nacelles', name: 'app_formations_nacelles', methods: ['GET'])]
    public function nacelles(): Response
    {
        $categories = [
            'A' => 'PEMP type A',
            'B' => 'PEMP type B',
        ];
        return $this->render('prestations/nacelles/index.html.twig', compact('categories'));
    }

    #[Route('/prestations/formations/nacelles/{cat}', name: 'app_formations_nacelles_cat', requirements: ['cat' => 'A|B'], methods: ['GET'])]
    public function nacellesShow(string $cat): Response
    {
        return $this->render('prestations/nacelles/show.html.twig', [
            'cat' => $cat,
            'title' => "CACES® R486 – Catégorie $cat",
        ]);
    }

#[Route(
        '/prestations/formations/chariots/categorie-{cat}',
        name: 'app_formations_chariots_cat',
        requirements: ['cat' => '1A|1B|2B|3|4|5'],
        methods: ['GET']
    )]
    public function chariotsCategory(string $cat): Response
    {
        // Tableau de config : une entrée = une page
        $pages = [
            '1A' => [
                'titre'       => 'CACES® R489 – Catégorie 1A',
                'resume'      => 'Maîtrisez la conduite en sécurité…',
                'hero_src'    => 'images/CACES_R489_1A.png',
                'description' => "
Transpalettes à conducteur porté et préparateurs de commandes, sans élévation du poste de conduite, avec une hauteur de levée limitée à 1,20 m.


Objectifs de la formation :

- Comprendre et appliquer les règles de sécurité liées à l’utilisation des chariots élévateurs

- Maîtriser les principales manœuvres : chargement et déchargement de camions, stockage/déstockage en palettier, déplacement de charges, etc...

- Acquérir les bases technologiques des chariots élévateurs et savoir lire une plaque de capacité


Pré-requis :

- Maîtrise de la langue française

- Connaissance des calculs de base (addition, soustraction, etc...)

- Être âgé de 18 ans minimum


Moyens pédagogiques :

- Ordinateur et vidéo-projecteur

- Supports de cours et vidéos pédagogiques

- Chariots élévateurs de différentes catégories

- Plateforme logistique conforme aux exigences du référentiel CACES® R489


Équipements nécessaires pour les participants :
(En cas de besoin, DP Formation peut fournir une partie de ces équipements, dans la limite des stocks disponibles — hors chaussures de sécurité.)

- Chaussures de sécurité

- Gants

- Gilet réfléchissant


Sanction de la formation :

- Évaluation théorique

- Évaluation pratique (pour chaque catégorie)

- Délivrance d’un CACES® et d’une attestation de formation en cas de réussite aux évaluations


Contenu théorique de la formation :

- Identifier le rôle des différentes instances de prévention : Inspection du Travail, Assurance Maladie / Cramif, Médecine du travail, organismes de contrôle technique, etc...

- Connaître les conditions nécessaires pour conduire un chariot élévateur et les responsabilités associées

- Reconnaître les principales catégories de chariots, leurs caractéristiques, leurs usages habituels et leurs limites

- Comprendre la technologie et la fonction des organes principaux : groupe propulseur, circuit hydraulique, mât, tablier porte-charge…

- Comprendre le fonctionnement des organes de service et des dispositifs de sécurité : coupe-circuit, frein de service, clés et dispositifs de condamnation, etc...

- Savoir lire et interpréter les pictogrammes et panneaux de signalisation

- Identifier les principales causes d’accidents liés à l’utilisation d’un chariot automoteur

- Repérer les risques potentiels présents sur un trajet défini

- Lire une plaque de charge et en déduire les conditions de stabilité du chariot

- Connaître les dispositifs de sécurité du conducteur : protège-conducteur, dosseret, bouclier, réglages du siège, équipements de protection individuelle, etc...

- Expliquer et justifier les interdictions concernant le transport ou l’élévation de personnes

- Connaître les règles de circulation et de conduite en intérieur comme en extérieur

- Comprendre l’influence des paramètres (état du sol, poids, vitesse…) sur la distance de freinage

- Identifier les produits dangereux à partir de leur étiquetage et connaître les risques liés à leur manutention


Contenu pratique de la formation :

- Vérifier l’adéquation du chariot à la manutention prévue

- Réaliser les contrôles et opérations nécessaires en début et fin de poste

- Circuler à vide et en charge, en marche avant/arrière, en virage et immobiliser le chariot en position de sécurité

- Circuler et s’arrêter sur un plan incliné

- Prendre et déposer une charge au sol

- Réaliser un gerbage et un dégerbage en pile

- Mettre en stock et déstocker des charges à tous les niveaux d’un palettier

- Charger et décharger un camion ou une remorque latéralement depuis le sol

- Charger et décharger une remorque à partir d’un quai par l’arrière

- Réaliser des opérations de picking (catégorie 7)

- Circuler avec une remorque en marche avant et marche arrière (catégorie 2B)

- Prendre, transporter et déposer des charges longues ou volumineuses

- Identifier les anomalies et difficultés rencontrées et les signaler à la hiérarchie

- Réaliser les opérations de maintenance relevant de son niveau


Validation (selon le référentiel R489) :

- Évaluation théorique

- Évaluation pratique : un parcours pratique par catégorie",
                'programme_url' => '#',
                'tarifs'      => ['inter' => 'à partir de 100€', 'intra' => 'sur devis'],
                'reserve_url' => $this->generateUrl('app_contact'),
                'infos'       => [
                    'Durée'  => '3 jours',
                    'Lieu'   => 'DP Formation Saint-Quentin',
                    'Public' => 'Caristes, manutentionnaires…',
                ],
            ],
            '1B' => [
                'titre'       => 'CACES® R489 – Catégorie 1B',
                'resume'      => 'Maîtrisez la conduite en sécurité…',
                'hero_src'    => 'images/CACES_R489_1B.png',
                'description' => "
Gerbeurs à conducteur porté, avec une hauteur de levée supérieure à 1,20 m
                

Objectifs de la formation :

- Comprendre et appliquer les règles de sécurité liées à l’utilisation des chariots élévateurs

- Maîtriser les principales manœuvres : chargement et déchargement de camions, stockage/déstockage en palettier, déplacement de charges, etc...

- Acquérir les bases technologiques des chariots élévateurs et savoir lire une plaque de capacité


Pré-requis :

- Maîtrise de la langue française

- Connaissance des calculs de base (addition, soustraction, etc...)

- Être âgé de 18 ans minimum


Moyens pédagogiques :

- Ordinateur et vidéo-projecteur

- Supports de cours et vidéos pédagogiques

- Chariots élévateurs de différentes catégories

- Plateforme logistique conforme aux exigences du référentiel CACES® R489


Équipements nécessaires pour les participants :
(En cas de besoin, DP Formation peut fournir une partie de ces équipements, dans la limite des stocks disponibles — hors chaussures de sécurité.)

- Chaussures de sécurité

- Gants

- Gilet réfléchissant


Sanction de la formation :

- Évaluation théorique

- Évaluation pratique (pour chaque catégorie)

- Délivrance d’un CACES® et d’une attestation de formation en cas de réussite aux évaluations


Contenu théorique de la formation :

- Identifier le rôle des différentes instances de prévention : Inspection du Travail, Assurance Maladie / Cramif, Médecine du travail, organismes de contrôle technique, etc...

- Connaître les conditions nécessaires pour conduire un chariot élévateur et les responsabilités associées

- Reconnaître les principales catégories de chariots, leurs caractéristiques, leurs usages habituels et leurs limites

- Comprendre la technologie et la fonction des organes principaux : groupe propulseur, circuit hydraulique, mât, tablier porte-charge…

- Comprendre le fonctionnement des organes de service et des dispositifs de sécurité : coupe-circuit, frein de service, clés et dispositifs de condamnation, etc...

- Savoir lire et interpréter les pictogrammes et panneaux de signalisation

- Identifier les principales causes d’accidents liés à l’utilisation d’un chariot automoteur

- Repérer les risques potentiels présents sur un trajet défini

- Lire une plaque de charge et en déduire les conditions de stabilité du chariot

- Connaître les dispositifs de sécurité du conducteur : protège-conducteur, dosseret, bouclier, réglages du siège, équipements de protection individuelle, etc...

- Expliquer et justifier les interdictions concernant le transport ou l’élévation de personnes

- Connaître les règles de circulation et de conduite en intérieur comme en extérieur

- Comprendre l’influence des paramètres (état du sol, poids, vitesse…) sur la distance de freinage

- Identifier les produits dangereux à partir de leur étiquetage et connaître les risques liés à leur manutention


Contenu pratique de la formation :

- Vérifier l’adéquation du chariot à la manutention prévue

- Réaliser les contrôles et opérations nécessaires en début et fin de poste

- Circuler à vide et en charge, en marche avant/arrière, en virage et immobiliser le chariot en position de sécurité

- Circuler et s’arrêter sur un plan incliné

- Prendre et déposer une charge au sol

- Réaliser un gerbage et un dégerbage en pile

- Mettre en stock et déstocker des charges à tous les niveaux d’un palettier

- Charger et décharger un camion ou une remorque latéralement depuis le sol

- Charger et décharger une remorque à partir d’un quai par l’arrière

- Réaliser des opérations de picking (catégorie 7)

- Circuler avec une remorque en marche avant et marche arrière (catégorie 2B)

- Prendre, transporter et déposer des charges longues ou volumineuses

- Identifier les anomalies et difficultés rencontrées et les signaler à la hiérarchie

- Réaliser les opérations de maintenance relevant de son niveau


Validation (selon le référentiel R489) :

- Évaluation théorique

- Évaluation pratique : un parcours pratique par catégorie",
                'programme_url' => '#',
                'tarifs'      => ['inter' => 'à partir de 100€', 'intra' => 'sur devis'],
                'reserve_url' => $this->generateUrl('app_contact'),
                'infos'       => [
                    'Durée'  => '3 jours',
                    'Lieu'   => 'DP Formation Saint-Quentin',
                    'Public' => 'Caristes, manutentionnaires…',
                ],
            ],
            '2B' => [
                'titre'       => 'CACES® R489 – Catégorie 2B',
                'resume'      => 'Maîtrisez la conduite en sécurité…',
                'hero_src'    => 'images/CACES_R489_2B.png',
                'description' => "
Chariots tracteurs industriels, d’une capacité de traction inférieure ou égale à 25 tonnes
                

Objectifs de la formation :

- Comprendre et appliquer les règles de sécurité liées à l’utilisation des chariots élévateurs

- Maîtriser les principales manœuvres : chargement et déchargement de camions, stockage/déstockage en palettier, déplacement de charges, etc...

- Acquérir les bases technologiques des chariots élévateurs et savoir lire une plaque de capacité


Pré-requis :

- Maîtrise de la langue française

- Connaissance des calculs de base (addition, soustraction, etc...)

- Être âgé de 18 ans minimum


Moyens pédagogiques :

- Ordinateur et vidéo-projecteur

- Supports de cours et vidéos pédagogiques

- Chariots élévateurs de différentes catégories

- Plateforme logistique conforme aux exigences du référentiel CACES® R489


Équipements nécessaires pour les participants :
(En cas de besoin, DP Formation peut fournir une partie de ces équipements, dans la limite des stocks disponibles — hors chaussures de sécurité.)

- Chaussures de sécurité

- Gants

- Gilet réfléchissant


Sanction de la formation :

- Évaluation théorique

- Évaluation pratique (pour chaque catégorie)

- Délivrance d’un CACES® et d’une attestation de formation en cas de réussite aux évaluations


Contenu théorique de la formation :

- Identifier le rôle des différentes instances de prévention : Inspection du Travail, Assurance Maladie / Cramif, Médecine du travail, organismes de contrôle technique, etc...

- Connaître les conditions nécessaires pour conduire un chariot élévateur et les responsabilités associées

- Reconnaître les principales catégories de chariots, leurs caractéristiques, leurs usages habituels et leurs limites

- Comprendre la technologie et la fonction des organes principaux : groupe propulseur, circuit hydraulique, mât, tablier porte-charge…

- Comprendre le fonctionnement des organes de service et des dispositifs de sécurité : coupe-circuit, frein de service, clés et dispositifs de condamnation, etc...

- Savoir lire et interpréter les pictogrammes et panneaux de signalisation

- Identifier les principales causes d’accidents liés à l’utilisation d’un chariot automoteur

- Repérer les risques potentiels présents sur un trajet défini

- Lire une plaque de charge et en déduire les conditions de stabilité du chariot

- Connaître les dispositifs de sécurité du conducteur : protège-conducteur, dosseret, bouclier, réglages du siège, équipements de protection individuelle, etc...

- Expliquer et justifier les interdictions concernant le transport ou l’élévation de personnes

- Connaître les règles de circulation et de conduite en intérieur comme en extérieur

- Comprendre l’influence des paramètres (état du sol, poids, vitesse…) sur la distance de freinage

- Identifier les produits dangereux à partir de leur étiquetage et connaître les risques liés à leur manutention


Contenu pratique de la formation :

- Vérifier l’adéquation du chariot à la manutention prévue

- Réaliser les contrôles et opérations nécessaires en début et fin de poste

- Circuler à vide et en charge, en marche avant/arrière, en virage et immobiliser le chariot en position de sécurité

- Circuler et s’arrêter sur un plan incliné

- Prendre et déposer une charge au sol

- Réaliser un gerbage et un dégerbage en pile

- Mettre en stock et déstocker des charges à tous les niveaux d’un palettier

- Charger et décharger un camion ou une remorque latéralement depuis le sol

- Charger et décharger une remorque à partir d’un quai par l’arrière

- Réaliser des opérations de picking (catégorie 7)

- Circuler avec une remorque en marche avant et marche arrière (catégorie 2B)

- Prendre, transporter et déposer des charges longues ou volumineuses

- Identifier les anomalies et difficultés rencontrées et les signaler à la hiérarchie

- Réaliser les opérations de maintenance relevant de son niveau


Validation (selon le référentiel R489) :

- Évaluation théorique

- Évaluation pratique : un parcours pratique par catégorie",
                'programme_url' => '#',
                'tarifs'      => ['inter' => 'à partir de 100€', 'intra' => 'sur devis'],
                'reserve_url' => $this->generateUrl('app_contact'),
                'infos'       => [
                    'Durée'  => '3 jours',
                    'Lieu'   => 'DP Formation Saint-Quentin',
                    'Public' => 'Caristes, manutentionnaires…',
                ],
            ],
            '3' => [
                'titre'       => 'CACES® R489 – Catégorie 3',
                'resume'      => 'Maîtrisez la conduite en sécurité…',
                'hero_src'    => 'images/CACES_R489_3.png',
                'description' => "
Chariots élévateurs frontaux à contrepoids, avec une capacité nominale inférieure ou égale à 6 tonnes


Objectifs de la formation :

- Comprendre et appliquer les règles de sécurité liées à l’utilisation des chariots élévateurs

- Maîtriser les principales manœuvres : chargement et déchargement de camions, stockage/déstockage en palettier, déplacement de charges, etc...

- Acquérir les bases technologiques des chariots élévateurs et savoir lire une plaque de capacité


Pré-requis :

- Maîtrise de la langue française

- Connaissance des calculs de base (addition, soustraction, etc...)

- Être âgé de 18 ans minimum


Moyens pédagogiques :

- Ordinateur et vidéo-projecteur

- Supports de cours et vidéos pédagogiques

- Chariots élévateurs de différentes catégories

- Plateforme logistique conforme aux exigences du référentiel CACES® R489


Équipements nécessaires pour les participants :
(En cas de besoin, DP Formation peut fournir une partie de ces équipements, dans la limite des stocks disponibles — hors chaussures de sécurité.)

- Chaussures de sécurité

- Gants

- Gilet réfléchissant


Sanction de la formation :

- Évaluation théorique

- Évaluation pratique (pour chaque catégorie)

- Délivrance d’un CACES® et d’une attestation de formation en cas de réussite aux évaluations


Contenu théorique de la formation :

- Identifier le rôle des différentes instances de prévention : Inspection du Travail, Assurance Maladie / Cramif, Médecine du travail, organismes de contrôle technique, etc...

- Connaître les conditions nécessaires pour conduire un chariot élévateur et les responsabilités associées

- Reconnaître les principales catégories de chariots, leurs caractéristiques, leurs usages habituels et leurs limites

- Comprendre la technologie et la fonction des organes principaux : groupe propulseur, circuit hydraulique, mât, tablier porte-charge…

- Comprendre le fonctionnement des organes de service et des dispositifs de sécurité : coupe-circuit, frein de service, clés et dispositifs de condamnation, etc...

- Savoir lire et interpréter les pictogrammes et panneaux de signalisation

- Identifier les principales causes d’accidents liés à l’utilisation d’un chariot automoteur

- Repérer les risques potentiels présents sur un trajet défini

- Lire une plaque de charge et en déduire les conditions de stabilité du chariot

- Connaître les dispositifs de sécurité du conducteur : protège-conducteur, dosseret, bouclier, réglages du siège, équipements de protection individuelle, etc...

- Expliquer et justifier les interdictions concernant le transport ou l’élévation de personnes

- Connaître les règles de circulation et de conduite en intérieur comme en extérieur

- Comprendre l’influence des paramètres (état du sol, poids, vitesse…) sur la distance de freinage

- Identifier les produits dangereux à partir de leur étiquetage et connaître les risques liés à leur manutention


Contenu pratique de la formation :

- Vérifier l’adéquation du chariot à la manutention prévue

- Réaliser les contrôles et opérations nécessaires en début et fin de poste

- Circuler à vide et en charge, en marche avant/arrière, en virage et immobiliser le chariot en position de sécurité

- Circuler et s’arrêter sur un plan incliné

- Prendre et déposer une charge au sol

- Réaliser un gerbage et un dégerbage en pile

- Mettre en stock et déstocker des charges à tous les niveaux d’un palettier

- Charger et décharger un camion ou une remorque latéralement depuis le sol

- Charger et décharger une remorque à partir d’un quai par l’arrière

- Réaliser des opérations de picking (catégorie 7)

- Circuler avec une remorque en marche avant et marche arrière (catégorie 2B)

- Prendre, transporter et déposer des charges longues ou volumineuses

- Identifier les anomalies et difficultés rencontrées et les signaler à la hiérarchie

- Réaliser les opérations de maintenance relevant de son niveau


Validation (selon le référentiel R489) :

- Évaluation théorique

- Évaluation pratique : un parcours pratique par catégorie",
                'programme_url' => '#',
                'tarifs'      => ['inter' => 'à partir de 100€', 'intra' => 'sur devis'],
                'reserve_url' => $this->generateUrl('app_contact'),
                'infos'       => [
                    'Durée'  => '3 jours',
                    'Lieu'   => 'DP Formation Saint-Quentin',
                    'Public' => 'Caristes, manutentionnaires…',
                ],
            ],
            '4' => [
                'titre'       => 'CACES® R489 – Catégorie 4',
                'resume'      => 'Maîtrisez la conduite en sécurité…',
                'hero_src'    => 'images/CACES_R489_4.png',
                'description' => "
Chariots élévateurs frontaux à contrepoids, avec une capacité nominale supérieure à 6 tonnes                
          

Objectifs de la formation :

- Comprendre et appliquer les règles de sécurité liées à l’utilisation des chariots élévateurs

- Maîtriser les principales manœuvres : chargement et déchargement de camions, stockage/déstockage en palettier, déplacement de charges, etc...

- Acquérir les bases technologiques des chariots élévateurs et savoir lire une plaque de capacité


Pré-requis :

- Maîtrise de la langue française

- Connaissance des calculs de base (addition, soustraction, etc...)

- Être âgé de 18 ans minimum


Moyens pédagogiques :

- Ordinateur et vidéo-projecteur

- Supports de cours et vidéos pédagogiques

- Chariots élévateurs de différentes catégories

- Plateforme logistique conforme aux exigences du référentiel CACES® R489


Équipements nécessaires pour les participants :
(En cas de besoin, DP Formation peut fournir une partie de ces équipements, dans la limite des stocks disponibles — hors chaussures de sécurité.)

- Chaussures de sécurité

- Gants

- Gilet réfléchissant


Sanction de la formation :

- Évaluation théorique

- Évaluation pratique (pour chaque catégorie)

- Délivrance d’un CACES® et d’une attestation de formation en cas de réussite aux évaluations


Contenu théorique de la formation :

- Identifier le rôle des différentes instances de prévention : Inspection du Travail, Assurance Maladie / Cramif, Médecine du travail, organismes de contrôle technique, etc...

- Connaître les conditions nécessaires pour conduire un chariot élévateur et les responsabilités associées

- Reconnaître les principales catégories de chariots, leurs caractéristiques, leurs usages habituels et leurs limites

- Comprendre la technologie et la fonction des organes principaux : groupe propulseur, circuit hydraulique, mât, tablier porte-charge…

- Comprendre le fonctionnement des organes de service et des dispositifs de sécurité : coupe-circuit, frein de service, clés et dispositifs de condamnation, etc...

- Savoir lire et interpréter les pictogrammes et panneaux de signalisation

- Identifier les principales causes d’accidents liés à l’utilisation d’un chariot automoteur

- Repérer les risques potentiels présents sur un trajet défini

- Lire une plaque de charge et en déduire les conditions de stabilité du chariot

- Connaître les dispositifs de sécurité du conducteur : protège-conducteur, dosseret, bouclier, réglages du siège, équipements de protection individuelle, etc...

- Expliquer et justifier les interdictions concernant le transport ou l’élévation de personnes

- Connaître les règles de circulation et de conduite en intérieur comme en extérieur

- Comprendre l’influence des paramètres (état du sol, poids, vitesse…) sur la distance de freinage

- Identifier les produits dangereux à partir de leur étiquetage et connaître les risques liés à leur manutention


Contenu pratique de la formation :

- Vérifier l’adéquation du chariot à la manutention prévue

- Réaliser les contrôles et opérations nécessaires en début et fin de poste

- Circuler à vide et en charge, en marche avant/arrière, en virage et immobiliser le chariot en position de sécurité

- Circuler et s’arrêter sur un plan incliné

- Prendre et déposer une charge au sol

- Réaliser un gerbage et un dégerbage en pile

- Mettre en stock et déstocker des charges à tous les niveaux d’un palettier

- Charger et décharger un camion ou une remorque latéralement depuis le sol

- Charger et décharger une remorque à partir d’un quai par l’arrière

- Réaliser des opérations de picking (catégorie 7)

- Circuler avec une remorque en marche avant et marche arrière (catégorie 2B)

- Prendre, transporter et déposer des charges longues ou volumineuses

- Identifier les anomalies et difficultés rencontrées et les signaler à la hiérarchie

- Réaliser les opérations de maintenance relevant de son niveau


Validation (selon le référentiel R489) :

- Évaluation théorique

- Évaluation pratique : un parcours pratique par catégorie",
                'programme_url' => '#',
                'tarifs'      => ['inter' => 'à partir de 100€', 'intra' => 'sur devis'],
                'reserve_url' => $this->generateUrl('app_contact'),
                'infos'       => [
                    'Durée'  => '3 jours',
                    'Lieu'   => 'DP Formation Saint-Quentin',
                    'Public' => 'Caristes, manutentionnaires…',
                ],
            ],
            '5' => [
                'titre'       => 'CACES® R489 – Catégorie 5',
                'resume'      => 'Maîtrisez la conduite en sécurité…',
                'hero_src'    => 'images/CACES_R489_5.png',
                'description' => "
Chariots élévateurs à mât rétractable                
                

Objectifs de la formation :

- Comprendre et appliquer les règles de sécurité liées à l’utilisation des chariots élévateurs

- Maîtriser les principales manœuvres : chargement et déchargement de camions, stockage/déstockage en palettier, déplacement de charges, etc...

- Acquérir les bases technologiques des chariots élévateurs et savoir lire une plaque de capacité


Pré-requis :

- Maîtrise de la langue française

- Connaissance des calculs de base (addition, soustraction, etc...)

- Être âgé de 18 ans minimum


Moyens pédagogiques :

- Ordinateur et vidéo-projecteur

- Supports de cours et vidéos pédagogiques

- Chariots élévateurs de différentes catégories

- Plateforme logistique conforme aux exigences du référentiel CACES® R489


Équipements nécessaires pour les participants :
(En cas de besoin, DP Formation peut fournir une partie de ces équipements, dans la limite des stocks disponibles — hors chaussures de sécurité.)

- Chaussures de sécurité

- Gants

- Gilet réfléchissant


Sanction de la formation :

- Évaluation théorique

- Évaluation pratique (pour chaque catégorie)

- Délivrance d’un CACES® et d’une attestation de formation en cas de réussite aux évaluations


Contenu théorique de la formation :

- Identifier le rôle des différentes instances de prévention : Inspection du Travail, Assurance Maladie / Cramif, Médecine du travail, organismes de contrôle technique, etc...

- Connaître les conditions nécessaires pour conduire un chariot élévateur et les responsabilités associées

- Reconnaître les principales catégories de chariots, leurs caractéristiques, leurs usages habituels et leurs limites

- Comprendre la technologie et la fonction des organes principaux : groupe propulseur, circuit hydraulique, mât, tablier porte-charge…

- Comprendre le fonctionnement des organes de service et des dispositifs de sécurité : coupe-circuit, frein de service, clés et dispositifs de condamnation, etc...

- Savoir lire et interpréter les pictogrammes et panneaux de signalisation

- Identifier les principales causes d’accidents liés à l’utilisation d’un chariot automoteur

- Repérer les risques potentiels présents sur un trajet défini

- Lire une plaque de charge et en déduire les conditions de stabilité du chariot

- Connaître les dispositifs de sécurité du conducteur : protège-conducteur, dosseret, bouclier, réglages du siège, équipements de protection individuelle, etc...

- Expliquer et justifier les interdictions concernant le transport ou l’élévation de personnes

- Connaître les règles de circulation et de conduite en intérieur comme en extérieur

- Comprendre l’influence des paramètres (état du sol, poids, vitesse…) sur la distance de freinage

- Identifier les produits dangereux à partir de leur étiquetage et connaître les risques liés à leur manutention


Contenu pratique de la formation :

- Vérifier l’adéquation du chariot à la manutention prévue

- Réaliser les contrôles et opérations nécessaires en début et fin de poste

- Circuler à vide et en charge, en marche avant/arrière, en virage et immobiliser le chariot en position de sécurité

- Circuler et s’arrêter sur un plan incliné

- Prendre et déposer une charge au sol

- Réaliser un gerbage et un dégerbage en pile

- Mettre en stock et déstocker des charges à tous les niveaux d’un palettier

- Charger et décharger un camion ou une remorque latéralement depuis le sol

- Charger et décharger une remorque à partir d’un quai par l’arrière

- Réaliser des opérations de picking (catégorie 7)

- Circuler avec une remorque en marche avant et marche arrière (catégorie 2B)

- Prendre, transporter et déposer des charges longues ou volumineuses

- Identifier les anomalies et difficultés rencontrées et les signaler à la hiérarchie

- Réaliser les opérations de maintenance relevant de son niveau


Validation (selon le référentiel R489) :

- Évaluation théorique

- Évaluation pratique : un parcours pratique par catégorie",
                'programme_url' => '#',
                'tarifs'      => ['inter' => 'à partir de 100€', 'intra' => 'sur devis'],
                'reserve_url' => $this->generateUrl('app_contact'),
                'infos'       => [
                    'Durée'  => '3 jours',
                    'Lieu'   => 'DP Formation Saint-Quentin',
                    'Public' => 'Caristes, manutentionnaires…',
                ],
            ],
        ];

        if (!isset($pages[$cat])) {
            throw $this->createNotFoundException('Catégorie inconnue');
        }

        return $this->render('prestations/chariots/show.html.twig', [
            'page' => $pages[$cat],
        ]);
    }
}
