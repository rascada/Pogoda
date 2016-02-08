<?php

namespace SyntaxError\NotificationBundle\Notify;

use Symfony\Component\DependencyInjection\ContainerInterface;
use SyntaxError\ApiBundle\Entity\ArchiveDayWindgust;
use SyntaxError\ApiBundle\Tools\Uniter;
use SyntaxError\NotificationBundle\Kernel\NotifyInterface;
use SyntaxError\NotificationBundle\Tools\DateTimer;

class ExtremeWind implements NotifyInterface
{
    use DateTimer;

    private $period;

    private $record = [];

    public function isActive(ContainerInterface $container)
    {
        $em = $container->get('doctrine.orm.default_entity_manager');
        $todayRecordSpeed = $em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgust")->findOneByDay($this->todayMidnight());

        $dayOfMonth = (new \DateTime('now'))->format("d");
        if($dayOfMonth < 7) return false;

        $monthMax = $em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgust")->createQueryBuilder('a')
            ->where('a.datetime >= :from')->andWhere('a.datetime <= :to')->andWhere('a.datetime != :this')
            ->setParameter('from', $this->monthStart()->getTimestamp())->setParameter('to', $this->monthEnd()->getTimestamp())
            ->setParameter('this', $todayRecordSpeed->getDatetime())->orderBy('a.max', 'desc')->setMaxResults(1)
            ->getQuery()->getOneOrNullResult();

        $yearMax = $em->getRepository("SyntaxErrorApiBundle:ArchiveDayWindgust")->createQueryBuilder('a')
            ->where('a.datetime >= :from')->andWhere('a.datetime <= :to')->andWhere('a.datetime != :this')
            ->setParameter('from', $this->yearStart()->getTimestamp())->setParameter('to', $this->yearEnd()->getTimestamp())
            ->setParameter('this', $todayRecordSpeed->getDatetime())->orderBy('a.max', 'desc')->setMaxResults(1)
            ->getQuery()->getOneOrNullResult();

        if($todayRecordSpeed->getMax() > $monthMax->getMax()) {
            $this->period = "miesiąca";
            $this->record['speed'] = $todayRecordSpeed;
            $this->record['dir'] = $em->getRepository("SyntaxErrorApiBundle:Archive")->findOneBy([
                'dateTime' => $todayRecordSpeed->getMaxtime()
            ])->getWindGustDir();
            return true;
        }

        if($todayRecordSpeed->getMax() > $yearMax->getMax()) {
            $this->period = "roku";
            $this->record['speed'] = $todayRecordSpeed;
            $this->record['dir'] = $em->getRepository("SyntaxErrorApiBundle:Archive")->findOneBy([
                'dateTime' => $todayRecordSpeed->getMaxtime()
            ])->getWindGustDir();
            return true;
        }

        return false;
    }

    public function getName()
    {
        return "[ALERT] Zanotowano ekstremalnie silne porywy wiatru.";
    }

    public function getContent(\Twig_Environment $twig)
    {
        return $twig->render('Extreme/wind.html.twig', [
            'period' => $this->period,
            'record' => $this->record['speed'],
            'translatedDir' => Uniter::windDirPl($this->record['dir'])
        ]);
    }
}
