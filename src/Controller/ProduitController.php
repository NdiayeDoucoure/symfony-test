<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProduitType;
use App\Entity\Produit;

final class ProduitController extends AbstractController{
    #[Route('/produits', name: 'produit_list')]
public function index(ProduitRepository $produitRepository): Response
{
    $produits = $produitRepository->findAll();
    return $this->render('produit/index.html.twig', ['produits' => $produits]);
}

#[Route('/produit/nouveau', name: 'produit_new')]
public function new(Request $request, EntityManagerInterface $em): Response
{
    $produit = new Produit();
    $form = $this->createForm(ProduitType::class, $produit);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($produit);
        $em->flush();
        return $this->redirectToRoute('produit_list');
    }

    return $this->render('produit/new.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
