<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WinkelwagenController extends AbstractController
{
    #[Route('/winkelwagen', name: 'app_winkelwagen')]
    public function index(EntityManagerInterface $em): Response
    {
        $products=$em->getRepository(Product::class)->findAll();

        return $this->render('winkelwagen/index.html.twig',[
            'products'=>$products
        ]);
    }

    #[Route('/makeorder/{id}',name:'app_makeorder')]
    public function makeOrder(EntityManagerInterface $em,Request $request, int $id): Response
    {
        $product=$em->getRepository(Product::class)->find($id);
        $form = $this->createFormBuilder()
            ->add('amount', IntegerType::class,[
                'required'=> true,
                'data'=>1,
                'label'=>'aantal'
            ])
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $session=$request->getSession();

            if(!$session->get('order')){
                $session->set('order',[]);
            }
            $amount=$form->get('amount')->getData();
            $order=$session->get('order');
            $order[]=[$id,$amount];
            $session->set('order',$order);
            $this->addFlash('success','Het product is toegevoegd' );

            return $this->redirectToRoute('app_winkelwagen');
        }
        return $this->render('winkelwagen/order.html.twig',[
            'product'=>$product,
            'form'=>$form
        ]);

    }
}
