<?php

namespace App\DataFixtures;

use App\Entity\MenuSection;
use App\Entity\MenuSectionItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class AppFixtures extends Fixture
{

    private KernelInterface $kernel;
    private Filesystem $filesystem;

    public function __construct(KernelInterface $kernel, Filesystem $filesystem)
    {
        $this->kernel = $kernel;
        $this->filesystem = $filesystem;
    }

    public function load(ObjectManager $manager): void
    {
        $uploadsDirSource = __DIR__ . '/uploads';
        $uploadsDirTarget = $this->kernel->getProjectDir() . '/public/uploads';

        if ($this->filesystem->exists($uploadsDirSource)) {
            $this->filesystem->mirror($uploadsDirSource, $uploadsDirTarget, options: ['override' => true]);
        }

        $menuSectionStarters = (new MenuSection)
            ->setName('Entrées')
            ->setPosition(0);
        $manager->persist($menuSectionStarters);

        $menuSectionMains = (new MenuSection)
            ->setName('Plats')
            ->setPosition(1);
        $manager->persist($menuSectionMains);

        $menuSectionDesserts = (new MenuSection)
            ->setName('Desserts')
            ->setPosition(2);
        $manager->persist($menuSectionDesserts);

        $menuSectionCaviar = (new MenuSectionItem)
            ->setImage('caviar.jpg')
            ->setName("Caviar Osciètre en Tulum Tempura & Beurre Blanc Matcha")
            ->setDescription("Perles de caviar osciètre déposées sur une fine tempura de maïs bleu mexicain, beurre blanc monté au matcha japonais, citron vert confit, nuage iodé et poudre de nori grillé.\nUn dialogue entre la tradition française et les terres sacrées du Yucatán.")
            ->setPrice('78')
            ->setPosition(0)
            ->setSection($menuSectionStarters);
        $manager->persist($menuSectionCaviar);

        $menuSectionFoieGras = (new MenuSectionItem)
            ->setImage('foie_gras.jpg')
            ->setName("Foie Gras de Canard «\u{00A0}Sumi-Yaki\u{00A0}» & Mole Noir")
            ->setDescription("Foie gras poêlé façon charbonnage japonais sumi-yaki, posé sur un mole noir oaxaqueño affiné 48 h, tuile de cacao fermenté, crémeux de maïs blanc et réduction de porto.\nUn choc délicat entre l’excellence française et la profondeur mexicaine.")
            ->setPrice('84')
            ->setPosition(1)
            ->setSection($menuSectionStarters);
        $manager->persist($menuSectionFoieGras);

        $menuSectionCrab = (new MenuSectionItem)
            ->setImage('crabe.jpg')
            ->setName("King Crab des Glaciers en Tom Yum Givré")
            ->setDescription("Chair de crabe royal légèrement tiédie, infusion froide Tom Yum thaï gélifiée, huile citronnelle-kafir, pétales de pomelo rose, chips de riz soufflé au paprika fumé.\nUne entrée brillante, vibrante, acide, explosive.")
            ->setPrice('92')
            ->setPosition(2)
            ->setSection($menuSectionStarters);
        $manager->persist($menuSectionCrab);

        $menuSectionLobster = (new MenuSectionItem)
            ->setImage('homard.jpg')
            ->setName("Homard Bleu de Bretagne, Yuzu Kosho & Sauce Paris-Marrakech")
            ->setDescription("Homard laqué au yuzu kosho, cuisson au chalumeau japonais, semoule aérienne parfumée au safran marocain, pois chiches croquants, sauce beurre-argan montée minute.\nUne partition croisée entre France, Japon et Maghreb.")
            ->setPrice('148')
            ->setPosition(0)
            ->setSection($menuSectionMains);
        $manager->persist($menuSectionLobster);

        $menuSectionBeef = (new MenuSectionItem)
            ->setImage('boeuf.jpg')
            ->setName("Filet de Bœuf Wagyu Rossini")
            ->setDescription("Wagyu A5 rôti au binchotan, foie gras poêlé façon Rossini, jus réduit au saké vieilli, truffe blanche fraîche, pomme Anna au beurre miso.\nLe classique français le plus emblématique, redessiné avec une précision japonaise absolue.")
            ->setPrice('210')
            ->setPosition(1)
            ->setSection($menuSectionMains);
        $manager->persist($menuSectionBeef);

        $menuSectionBass = (new MenuSectionItem)
            ->setImage('bar.jpg')
            ->setName("Bar de Ligne, Escabèche Thaï & Harissa Blanche")
            ->setDescription("Bar cuit sur sa peau croustillante, escabèche thaï au galanga et citronnelle, purée d’aubergine brûlée, harissa blanche légèrement fumée, pickles de mangue verte.\nUn plat qui traverse la Méditerranée et la Thaïlande en un seul souffle.")
            ->setPrice('135')
            ->setPosition(2)
            ->setSection($menuSectionMains);
        $manager->persist($menuSectionBass);

        $menuSectionCoconutCloud = (new MenuSectionItem)
            ->setImage('nuage_de_coco.jpg')
            ->setName("Nuage de Coco & Truffe Noire, Glace Riz Gluant")
            ->setDescription("Mousse coco ultra légère, touches de truffe noire, sorbet riz gluant façon khao niao, coulis passion-gingembre, dentelle croustillante au sésame noir.\nUne interprétation gastronomique d’un dessert thaï mythique.")
            ->setPrice('38')
            ->setPosition(0)
            ->setSection($menuSectionDesserts);
        $manager->persist($menuSectionCoconutCloud);

        $menuSectionSouffle = (new MenuSectionItem)
            ->setImage('souffle.jpg')
            ->setName("Soufflé Paris-Kyoto au Sésame Blanc & Sakura")
            ->setDescription("Soufflé parfumé au sésame blanc torréfié, cœur coulant à la fleur de cerisier, servi avec une glace au lait ribot infusée au shiso rouge.\nUn pont entre les salons parisiens et les jardins de Kyoto.")
            ->setPrice('42')
            ->setPosition(1)
            ->setSection($menuSectionDesserts);
        $manager->persist($menuSectionSouffle);

        $menuSectionMillefeuille = (new MenuSectionItem)
            ->setImage('millefeuille.jpg')
            ->setName("Millefeuille Caramel Cajeta & Vanille Bourbon")
            ->setDescription("Feuilletage inversé extra-croustillant, crème légère à la vanille Bourbon, caramel cajeta mexicain, pointe de mezcal, amandes grillées au beurre salé.\nUn dessert français réinventé à travers les plaines mexicaines.")
            ->setPrice('36')
            ->setPosition(2)
            ->setSection($menuSectionDesserts);
        $manager->persist($menuSectionMillefeuille);

        $manager->flush();
    }
}
