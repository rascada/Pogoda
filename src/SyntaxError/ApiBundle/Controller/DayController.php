<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DayController extends Controller
{
    public function recordsAction(Request $request, $ext)
    {
        $dateTime = new \DateTime(
            $request->query->has('date') ? $request->query->get('date')." 00:00:00" : 'now'
        );
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;

        $archive = $this->get('syntax_error_api.archive')->handleDate($dateTime)->initService('day');
        $jsoner = $archive->getRecords($request->query);

        return $ext == 'json' ? $jsoner->createResponse($call) : $this->render(
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
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;

        $archive = $this->get('syntax_error_api.archive')->handleDate($dateTime)->initService('day');
        try {
            $jsoner = $archive->getChart($type);
        } catch(\RuntimeException $e) {
            return $ext == 'json' ? new JsonResponse('Invalid property '.$type, 500) : $this->render(
                "SyntaxErrorApiBundle:Day:charts.html.twig", [
                'title' => 'Day: '.$dateTime->format("d.m.Y"),
                'json' => '"Invalid property '.$type.'"'
            ], new Response(null, 500));
        }

        return $ext == 'json' ? $jsoner->createResponse($call) : $this->render(
            "SyntaxErrorApiBundle:Day:charts.html.twig", [
            'title' => 'Day '.ucfirst($type).": ".$dateTime->format("d.m.Y"),
            'json' => $jsoner->getJsonString()
        ]);
    }
}
