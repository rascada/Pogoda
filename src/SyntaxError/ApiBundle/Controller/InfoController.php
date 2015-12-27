<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InfoController extends Controller
{
    public function sentenceAction(Request $request, $ext)
    {
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;
        $jsoner = $this->get('syntax_error_api.info')->all();

        return $ext == 'json' ? $jsoner->createResponse($call) : $this->render(
            'SyntaxErrorApiBundle:Info:sentence.html.twig', [
            'json' => $jsoner->getJsonString()
        ]);
    }

    public function socketAction()
    {
        return $this->render("SyntaxErrorApiBundle:Info:socket.html.twig");
    }
}
