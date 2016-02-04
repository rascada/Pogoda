<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use SyntaxError\NotificationBundle\Kernel\RedisStorage;

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

    public function subscribeAction($type, Request $request)
    {
        if(!$request->request->has('email')) {
            return new JsonResponse(['status' => 'Require email in POST parameters.', 500]);
        }
        $redisStorage = new RedisStorage('127.0.0.1');
        if($type == 'subscribe') {
            return $redisStorage->addSubscriber($request->request->get('email')) ? new JsonResponse(['status' => 'Added.']) : new JsonResponse(['status' => 'Exist.'], 500);
        }

        return $redisStorage->removeSubscriber($request->request->get('email')) ? new JsonResponse(['status' => 'Removed.']) : new JsonResponse(['status' => 'Not found.'], 404);
    }
}
