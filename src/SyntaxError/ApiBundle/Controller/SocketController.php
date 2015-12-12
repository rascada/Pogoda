<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SocketController extends Controller
{
    public function informationAction()
    {
        return $this->render("SyntaxErrorApiBundle:Socket:information.html.twig", [
            'title' => 'Socket'
        ]);
    }
}
