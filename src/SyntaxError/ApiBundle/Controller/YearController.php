<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class YearController extends Controller
{
    public function recordsAction(Request $request, $ext)
    {
        $dateTime = new \DateTime(
            $request->query->has('date') ? $request->query->get('date')." 00:00:00" : 'now'
        );
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;

        $archive = $this->get('syntax_error_api.archive')->handleDate($dateTime)->initService('year');
        $jsoner = $archive->getRecords($request->query);

        return $ext == 'json' ? $jsoner->createResponse($call) : $this->render(
            "SyntaxErrorApiBundle:Year:records.html.twig", [
            'title' => 'Year records: '.$dateTime->format("Y") ,
            'json' => $jsoner->getJsonString()
        ]);
    }

    public function chartsAction(Request $request, $type, $ext)
    {
        $dateTime = new \DateTime(
            $request->query->has('date') ? $request->query->get('date')." 00:00:00" : 'now'
        );
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;

        $archive = $this->get('syntax_error_api.archive')->handleDate($dateTime)->initService('year');
        $jsoner = $archive->getChart($type);

        return $ext == 'json' ? $jsoner->createResponse($call) : $this->render(
            "SyntaxErrorApiBundle:Year:charts.html.twig", [
            'title' => 'Year '.ucfirst($type).": ".$dateTime->format("Y"),
            'json' => $jsoner->getJsonString()
        ]);
    }
}
