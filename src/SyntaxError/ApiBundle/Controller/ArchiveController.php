<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArchiveController extends Controller
{
    public function recordsAction(Request $request, $period, $ext = 'default')
    {
        $dateTime = new \DateTime(
            $request->query->has('date') ? $request->query->get('date')." 00:00:00" : 'now'
        );
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;

        $archive = $this->get('syntax_error_api.archive')->handleDate($dateTime)->initService($period);
        $jsoner = $archive->getRecords($request->query);
        $ucfPeriod = ucfirst($period);

        return $ext == 'json' ? $jsoner->createResponse($call) : $this->render(
            "SyntaxErrorApiBundle:Archive:records.html.twig", [
            'title' => $ucfPeriod.' records: '.$dateTime->format( $this->datetimeFormat($period) ) ,
            'json' => $jsoner->getJsonString()
        ]);
    }

    public function chartsAction(Request $request, $period, $type, $ext = 'default')
    {
        $dateTime = new \DateTime(
            $request->query->has('date') ? $request->query->get('date')." 00:00:00" : 'now'
        );
        $call = $request->query->has('callback') ? $request->query->get('callback') : null;

        $archive = $this->get('syntax_error_api.archive')->handleDate($dateTime)->initService($period);
        $jsoner = $archive->getChart($type);
        $ucfPeriod = ucfirst($period);

        return $ext == 'json' ? $jsoner->createResponse($call) : $this->render(
            "SyntaxErrorApiBundle:Archive:charts.html.twig", [
            'title' => $ucfPeriod.' '.ucfirst($type).": ".$dateTime->format( $this->datetimeFormat($period) ),
            'json' => $jsoner->getJsonString()
        ]);
    }

    private function datetimeFormat($period)
    {
        switch($period) {
            case 'year': return 'Y';
            case 'month': return 'Y M';
        }
        return 'Y-m-d';
    }
}
