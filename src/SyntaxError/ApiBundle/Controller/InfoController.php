<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InfoController extends Controller
{
    public function sentenceAction($ext)
    {
        return $this->render('SyntaxErrorApiBundle:Info:sentence.html.twig', [

        ]);
    }

    public function socketAction()
    {
        return $this->render("SyntaxErrorApiBundle:Info:socket.html.twig", [
            'title' => 'Socket'
        ]);
    }
}
