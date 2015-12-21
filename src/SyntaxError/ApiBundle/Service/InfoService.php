<?php

namespace SyntaxError\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use SyntaxError\ApiBundle\Tools\Jsoner;
use SyntaxError\ApiBundle\Tools\Uniter;

class InfoService
{
    private $em;

    private $last;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->last = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findLast();
    }

    private function temperature()
    {
        $tempTrend = round($this->em->getRepository("SyntaxErrorApiBundle:Archive")->getLastTempTrend(), 3);
        $tempSentence = "Aktualna temperatura wynosi ".round($this->last->getOutTemp(), 2).Uniter::temp;
        if(!$tempTrend) {
            $tempSentence .= ' i jest stała.';
        } else {
            $tempSentence .= ($tempTrend > 0 ? " i rośnie " : " i spada ");
            $tempSentence .= $tempTrend.Uniter::temp.Uniter::trend.".";
        }
        return $tempSentence;
    }

    public function all()
    {
        $data = [];
        foreach(get_class_methods($this) as $method) {
            if($method != '__construct' && $method != 'all') {
                $returned = call_user_func([$this, $method]);
                if( is_array($returned) ) $data = array_merge($data, $returned);
                else $data[] = $returned;
            }
        }
        $jsoner = new Jsoner();
        $jsoner->createJson($data);
        return $jsoner;
    }
}
