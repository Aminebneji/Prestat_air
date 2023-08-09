<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Purchase;
use App\Entity\User;
use App\Form\PurchaseType;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class PurchaseController extends AbstractController
{
    #[Route('purchase/product/{id}', name: 'product_purchase')]
    public function purchaseProduct(Request $request, Products $products, ManagerRegistry $managerRegistry , User $user)
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
            
            $user = $this->getUser();
            if ($user) {
                $purchase->setUser($user); 
            }
            // Sauvegarder l'achat en base de données
            $manager = $managerRegistry->getManager();
            $manager->persist($purchase);
            $manager->flush();

            return $this->redirectToRoute('product_purchase');
        }

        return $this->render('products\productPurchase.html.twig', [
            'form' => $form->createView(),
            'product' => $products,
            'user' => $user
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
