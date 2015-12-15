<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SyntaxError\ApiBundle\Tools\Jsoner;

class BasicController extends Controller
{
    public function nowAction(Request $request)
    {
        $live = $this->get('syntax_error_api.live');
        $jsoner = new Jsoner();
        $data = [];

        if( !$request->query->count() ) {
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

        return $request->query->has('type') && $request->query->get('type') == 'json' ? $jsoner->createResponse() : $this->render(
            "SyntaxErrorApiBundle:Basic:now.html.twig", [
                'title' => 'Basic',
                'json' => $jsoner->getJsonString()
        ]);
    }

    public function wundergroundAction(Request $request, $type)
    {
        $jsonString = $this->get('syntax_error_api.wu')->read($type, 2*60);

        if( $request->query->has('type') && $request->query->get('type') == 'json' ) {
            $response = new Response($jsonString);
            $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        } else {
            $response = new Response($this->renderView("SyntaxErrorApiBundle:Basic:wunderground.html.twig", [
                'title' => ucfirst($type),
                'json' => $jsonString
            ]));
        }
        return $response;
    }
}
