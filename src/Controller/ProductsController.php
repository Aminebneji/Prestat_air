<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductType;
use App\Form\sizeType;
use App\Repository\ProductsRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ProductsController extends AbstractController
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/products', name: 'app_products')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig', [
            'controller_name' => 'ProductsController',
        ]);
    }

    #[Route('/product/create', name: 'product_create')]
    public function create(Request $request): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if (!empty($image)) {
                $imgName = time() . '-img.' . $image->guessExtension();
                $image->move($this->getParameter('product_img_dir'), $imgName);
                $product->setImage($imgName);
                $product->setCreatedAt(new \DateTimeImmutable);
            }

            $manager = $this->managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute('product_create');
        }
        return $this->render('products/createProduct.html.twig', [
            'ProductForm' => $form->createView()
        ]);
    }


    #[Route('/admin/product/update/{id}', name: 'product_update')]
    public function update(Products $product, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form['image']->getData();
            if ($image !== null) {
                $oldImg1Path = $this->getParameter('product_img_dir') . '/' . $product->getimage();
                if (file_exists($oldImg1Path)) {
                    unlink($oldImg1Path);
                }
                $newImg1Name = time() . '-1.' . $image->guessExtension();
                $image->move($this->getParameter('product_img_dir'), $newImg1Name);
                $product->setImage($newImg1Name);
            }


            $manager = $this->managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute('admin_products');
        }

        return $this->render('products/createProduct.html.twig',[
            'ProductForm' => $form->createView()
        ]);
    }


    #[Route('/research/all', name: 'showAllProducts')]
    public function showAllProducts(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/showAllProducts.html.twig', [
            'products' => $productsRepository->findAll()
        ]);
    }

    #[Route('/admin/products', name: 'admin_products')]
    public function adminList(ProductsRepository $productRepository): Response
    {
        return $this->render('products/adminListProducts.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    #[Route('/admin/products/delete/{id}', name: 'product_delete')]
    public function delete(Products $product, ManagerRegistry $managerRegistry): Response
    {
        $manager = $managerRegistry->getManager();
        $manager->remove($product);
        $manager->flush();
        return $this->redirectToRoute('admin_products');
    }

    #[Route('/product/{name}', name: 'product_show')]
    public function show(ProductsRepository $productRepository, string $name ): Response
    {   
        return $this->render('products/show.html.twig', [
            'product' => $productRepository->findOneBy(['name' => $name])
        ]);
    }

}
