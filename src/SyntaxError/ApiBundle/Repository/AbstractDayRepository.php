<?php

namespace SyntaxError\ApiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SyntaxError\ApiBundle\Interfaces\ArchiveDay;

abstract class AbstractDayRepository extends EntityRepository
{
    /**
     * @param \DateTime $dateTime
     * @param $max
     * @return null|ArchiveDay
     */
    public function findMonthRecord(\DateTime $dateTime, $max = true)
    {
        return $this->findRecordBetween(
            new \DateTime( $dateTime->format('Y-m-01 00:00:00') ), new \DateTime( $dateTime->format('Y-m-t 00:00:00') ), $max
        );
    }

    /**
     * @param \DateTime $dateTime
     * @param bool|true $max
     * @return null|ArchiveDay
     */
    public function findYearRecord(\DateTime $dateTime, $max = true)
    {
        return $this->findRecordBetween(
            new \DateTime( $dateTime->format('Y-01-01 00:00:00') ), new \DateTime( $dateTime->format('Y-12-31 00:00:00') ), $max
        );
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @param bool $max
     * @return null|ArchiveDay
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findRecordBetween(\DateTime $from, \DateTime $to, $max = true)
    {
        return $this->createQueryBuilder('a')
            ->where('a.datetime BETWEEN :from AND :to')
            ->setParameter( 'from', $from->getTimestamp() )->setParameter( 'to', $to->getTimestamp() )
            ->orderBy('a.'.( $max ? 'max' : 'min'), $max ? 'desc' : 'asc')
            ->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array|ArchiveDay[]
     */
    public function findBetween(\DateTime $from, \DateTime $to)
    {
        return $this->getEntityManager()->getRepository($this->getEntityName())
            ->createQueryBuilder('a')->where('a.datetime BETWEEN :from AND :to')
            ->setParameter( 'from', $from->getTimestamp() )->setParameter( 'to', $to->getTimestamp() )
            ->orderBy('a.datetime', 'asc')->getQuery()->getResult();
    }

    /**
     * @param \DateTime $day
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByDay(\DateTime $day)
    {
        $start = new \DateTime($day->format("Y-m-d 00:00:00"));
        $day->setTime(23, 59, 59);
        return $this->getEntityManager()->getRepository($this->getEntityName())
            ->createQueryBuilder('a')->where('a.datetime BETWEEN :day_start AND :day_end')
            ->setParameter('day_start', $start->getTimestamp())
            ->setParameter('day_end', $day->getTimestamp())
            ->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }
}
