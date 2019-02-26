<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        return $this->render('Controller/home.html.twig');
    }

    /**
     * @Route("/number", name="number")
     */
    public function number()
    {
        $number = random_int(0, 10);

        return $this->render('Controller/number.html.twig', [
            'number' => $number
        ]);
        
    }

}
