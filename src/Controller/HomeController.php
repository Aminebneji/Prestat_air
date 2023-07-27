<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/', name: 'home')]
    public function produitPlusProcheAction(ProductsRepository $product)
    {
        $produitFind = $product->findAll();
        $closest = $this->findClosest($produitFind);

        return $this->render('home/index.html.twig', [
            'closest' => $closest,
        ]);
    }
    private function findClosest($product)
    {
        $date = new \DateTime();
        $closest = null;
        $intervalMin = null;

        foreach ($product as $products) {
            $dateProduit = $products->getCreatedAt();
            $interval = $date->diff($dateProduit);
            $totalInterval = $interval->days + ($interval->h / 24) + ($interval->i / 60) + ($interval->s / 3600); // Convertit l'interval en jours, heures, minutes et secondes en une seule valeur.

            if ($closest === null || $totalInterval < $intervalMin) {
                $closest = $products;
                $intervalMin = $totalInterval;
            }
        }

        return $closest;
    }
}
