<?php

namespace SyntaxError\NotificationBundle\Kernel;

use Mailgun\Mailgun;

/**
 * Class Notifier
 * Kernel of cron application for sending notifies for subscriber emails.
 *
 * @package SyntaxError\NotificationBundle\Kernel
 */
class Notifier
{
    /**
     * @var Mailgun
     */
    private $gun;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var RedisStorage
     */
    private $redis;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Notifier constructor.
     */
    public function __construct()
    {
        $kernel = new \AppKernel('dev', true);
        $kernel->boot();
        $this->container = $kernel->getContainer();
        $key = $this->container->getParameter('gun_key');

        $this->gun = new Mailgun($key, 'api.mailgun.net', 'v3', true);
        $this->redis = new RedisStorage('127.0.0.1');

        $twigCachePath = __DIR__."/../../../../app/cache/notify";
        if(!file_exists($twigCachePath)) {
            mkdir($twigCachePath, 0777);
        }
        $loader = new \Twig_Loader_Filesystem(__DIR__."/../Resources/views");
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => $twigCachePath,
        ));
    }

    /**
     * Run checking of notifies and send active.
     *
     * @void
     */
    public function run()
    {
        $className = 'NotificationBundle\Notify';
        foreach(new \DirectoryIterator(__DIR__."/../Notify") as $notifyFile) {
           if(!$notifyFile->isDot()) {
               $class = str_replace(".".$notifyFile->getExtension(), '', '\SyntaxError\NotificationBundle\Notify\\'.$notifyFile->getFilename());
               $object = new $class;
               if(!($object instanceof NotifyInterface)) throw new \UnexpectedValueException(
                   sprintf("All classes in '%s' should implements NotifyInterface. Check '%s' class.", $className, $class)
               );

               if(!$this->redis->isLocked(get_class($object))) {
                   echo $this->checkNotify($object) ? "Notify $class send to subscribers. [".count($this->redis->getSubscribers())."]" : "Notify $class not active now.";
               } else {
                   echo "Class $class is locked now.";
               }
               echo PHP_EOL;
           }
        }
    }

    /**
     * Check one notify and send to subscribers if it is active.
     * Return true after send.
     *
     * @param NotifyInterface $notify
     * @return bool
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    private function checkNotify(NotifyInterface $notify)
    {
        if(!$notify->isActive($this->container)) return false;

        foreach($this->redis->getSubscribers() as $subscriber) {
            $this->gun->sendMessage($this->container->getParameter('gun_mail'), [
                'from'    => 'Stacja pogodowa Skałągi <info@pogoda.skalagi.pl>',
                'to'      => $subscriber,
                'subject' => $notify->getName(),
                'text'    => $notify->getContent($this->twig)
            ]);
        }

        $this->redis->lock(get_class($notify));
        return true;
    }
}
