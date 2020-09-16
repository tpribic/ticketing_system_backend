<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class TestController extends AbstractController
{

    /**
     * @Route("/test", name="test")
     * @Security("is_granted('ROLE_USER')")
     */
    public function index()
    {
        return $this->json([
            'message' => 'This is a message from the backend!!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }
}
