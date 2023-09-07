<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Purchase;
use App\Form\PurchaseType;
use App\Repository\PurchaseRepository;
use App\Service\CartService as ServiceCartService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class PurchaseController extends AbstractController
{
    #[Route('purchase/product/{id}', name: 'product_purchase')]
    public function purchaseProduct(Request $request, Products $products, ManagerRegistry $managerRegistry, CartController $cart, ServiceCartService $cartService)
    {
        $purchase = new Purchase();
        $purchase->setProduct($products);

        $availableSizes = [];
        foreach ($products->getadminSelectedsize() as $sizeEntity) {
            $availableSizes[$sizeEntity] = $sizeEntity;
        }

        $form = $this->createForm(PurchaseType::class, $purchase, [
            'availableSizes' => $availableSizes,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            $selectedSizeId = $form->get('selectedSize')->getData();
            // Remplir les données de l'entité Purchase
            $purchase->setSelectedSize($selectedSizeId);

            // Récupérer l'utilisateur connecté
            $userForPurchase = $this->getUser();
            if ($userForPurchase) {
                $purchase->setUser($userForPurchase); 
            }
            // Sauvegarder l'achat en base de données
            $manager = $managerRegistry->getManager();
            $manager->persist($purchase);
            $manager->flush();

            // ajout au panier du produit par son id
            $productId = $products->getId(); 
            $cart->add($cartService , $productId , $request);

            return $this->redirectToRoute('cart');
        }

        return $this->render('products\productPurchase.html.twig', [
            'form' => $form->createView(),
            'currentProduct' => $products,
        ]);
    }

    #[Route('/admin/purchase', name: 'admin_purchase')]
    public function adminListPurchase(PurchaseRepository $purchaseRepository): Response
    {

        return $this->render('products\adminListPurchases.html.twig', [
            'purchase' => $purchaseRepository->findAll(),
        ]);
    }
}
