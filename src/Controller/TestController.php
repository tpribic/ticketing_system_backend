<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="test")
     */
    public function index()
    {
        return $this->json([
            'message' => 'This is a message from the backend!!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }
}
