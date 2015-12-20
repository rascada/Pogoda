<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SyntaxError\ApiBundle\Tools\Jsoner;

class BasicController extends Controller
{
    public function nowAction(Request $request, $ext = 'default')
    {
        $live = $this->get('syntax_error_api.live');
        $jsoner = new Jsoner();
        $data = [];
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;

        if( !$request->query->count() || ($request->query->count() == 1 && $request->query->has('callback')) ) {
            foreach(get_class_methods('SyntaxError\ApiBundle\Service\LiveService') as $method) {
                if($method == '__construct' || $method == 'createTime') continue;
                $key = strtolower( str_replace('create', '', $method) );
                $data[$key] = call_user_func([$live, $method]);
            }
        }

        foreach($request->query->all() as $key => $param) {
            $methodName = "create".ucfirst($key);
            if( method_exists($live, $methodName) ) {
                $data[$key] = call_user_func([$live, $methodName]);
            }
        }
        $data['time'] = $live->createTime();
        $jsoner->createJson($data);

        return $ext == 'json' ? $jsoner->createResponse($call) : $this->render(
            "SyntaxErrorApiBundle:Basic:now.html.twig", [
                'title' => 'Basic',
                'json' => $jsoner->getJsonString()
        ]);
    }

    public function wundergroundAction(Request $request, $type, $ext = 'default')
    {
        $jsonString = $this->get('syntax_error_api.wu')->read($type, 2*60);
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;

        if( $ext == 'json' ) {
            $response = new Response($call ? ($call."($jsonString)") : $jsonString);
            $response->headers->set(
                'Content-Type',
                ($call ? 'application/javascript': 'application/json' ).'; charset=utf-8'
            );
            $response->headers->set('Access-Control-Allow-Origin', '*');

        } else {
            $response = new Response($this->renderView("SyntaxErrorApiBundle:Basic:wunderground.html.twig", [
                'title' => ucfirst($type),
                'json' => $jsonString
            ]));
        }
        return $response;
    }
}
