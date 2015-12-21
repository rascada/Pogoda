<?php

namespace SyntaxError\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use SyntaxError\ApiBundle\Tools\Jsoner;

class InfoService
{
    private $em;

    private $last;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->last = $this->em->getRepository("SyntaxErrorApiBundle:Archive")->findLast();
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
