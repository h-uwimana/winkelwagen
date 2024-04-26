<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WinkelwagenController extends AbstractController
{
    #[Route('/winkelwagen', name: 'app_winkelwagen')]
    public function index(EntityManagerInterface $em): Response
    {
        $products=$em->getRepository(Product::class)->findAll();
        //dd($employees);

        return $this->render('winkelwagen/index.html.twig',[
            'products'=>$products
        ]);
    }

    #[Route('/makeorder/{id}',name:'app_makeorder')]
    public function makeOrder(EntityManagerInterface $em,Request $request, int $id): Response
    {

    }
}
