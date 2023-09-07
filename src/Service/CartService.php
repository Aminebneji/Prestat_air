<?php

namespace App\Service;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    protected $requestStack;
    protected $productRepository;

    public function __construct(RequestStack $requestStack, ProductsRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    public function add(int $id)
    {   // récupère le panier ou un tableau vide
        $cart = $this->requestStack->getSession()->get('cart', []); 
        // si le produit est déjà dans le panier
        if (!empty($cart[$id])) { 
            // incrémente de 1 la quantité associée
            $cart[$id]++; 
        } else {
            // définit la quantité associée à 1
            $cart[$id] = 1; 
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }


    public function remove(int $id): void
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function delete(int $id): void
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function clear(): void
    {   
        
        $this->requestStack->getSession()->remove('cart');

    }

    public function getCart(): array
    {   // récupère le panier en session
        $sessionCart = $this->requestStack->getSession()->get('cart', []); 
        // initialise un nouveau panier
        $cart = []; 
        foreach ($sessionCart as $id => $quantity) {
            $element = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
            $cart[] = $element;
        }
        return $cart;
    }

    public function getTotal(): float
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $element) {
            $product = $element['product'];
            $total += $product->getPrice() * $element['quantity'];
        }

        return $total;
    }
}
