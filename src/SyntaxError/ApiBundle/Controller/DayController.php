<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SyntaxError\ApiBundle\Tools\Jsoner;

class DayController extends Controller
{
    public function recordsAction(Request $request, $ext)
    {
        $dateTime = new \DateTime(
            $request->query->has('date') ? $request->query->get('date')." 00:00:00" : 'now'
        );
        $request->query->remove('date');
        $day = $this->get('syntax_error_api.day');
        $data = [];
        if( !$request->query->count() ) {
            foreach(get_class_methods('SyntaxError\ApiBundle\Service\DayService') as $method) {
                if( preg_match('/create/', $method) ) {
                    $key = strtolower( str_replace('create', '', $method) );
                    $data[$key] = call_user_func_array([$day, $method], [$dateTime]);
                }
            }
        }

        foreach($request->query->all() as $key => $param) {
            $methodName = "create".ucfirst($key);
            if( method_exists($day, $methodName) ) {
                $data[$key] = call_user_func_array([$day, $methodName], [$dateTime]);
            }
        }
        $jsoner = new Jsoner();
        $jsoner->createJson($data);

        return $ext == 'json' ? $jsoner->createResponse() : $this->render(
            "SyntaxErrorApiBundle:Day:records.html.twig", [
            'title' => 'Day records: '.$dateTime->format("d.m.Y") ,
            'json' => $jsoner->getJsonString()
        ]);
    }

    public function chartsAction(Request $request, $type, $ext)
    {
        $dateTime = new \DateTime(
            $request->query->has('date') ? $request->query->get('date')." 00:00:00" : 'now'
        );
        try {
            $data = $this->get('syntax_error_api.day')->highFormatter($dateTime, $type);
        } catch(\RuntimeException $e) {
            return $ext == 'json' ? new JsonResponse('Invalid property '.$type, 500) : $this->render(
                "SyntaxErrorApiBundle:Day:charts.html.twig", [
                'title' => 'Day: '.$dateTime->format("d.m.Y"),
                'json' => '"Invalid property '.$type.'"'
            ], new Response(null, 500));
        }

        $jsoner = new Jsoner();
        $jsoner->createJson($data);

        return $ext == 'json' ? $jsoner->createResponse() : $this->render(
            "SyntaxErrorApiBundle:Day:charts.html.twig", [
            'title' => 'Day '.ucfirst($type).": ".$dateTime->format("d.m.Y"),
            'json' => $jsoner->getJsonString()
        ]);
    }
}
