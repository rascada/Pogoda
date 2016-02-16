<?php

namespace SyntaxError\NotificationBundle\Kernel;

/**
 * Class Notifier
 * Kernel of cron application for sending notifies for subscriber emails.
 *
 * @package SyntaxError\NotificationBundle\Kernel
 */
class Notifier
{
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
        $kernel = new \AppKernel('prod', false);
        $kernel->boot();
        $this->container = $kernel->getContainer();

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

               echo "[".(new \DateTime('now'))->format("Y-m-d H:i:s")."] | ";
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

        $findQueues = false;
        foreach($this->redis->getSubscribers() as $subscriber) {
            $message = \Swift_Message::newInstance()
                ->setFrom([$this->container->getParameter('mailer_user') => 'Stacja pogodowa Skałągi'])
                ->setTo($subscriber)
                ->setSubject($notify->getName())
                ->setBody($notify->getContent($this->twig), 'text/html', 'utf-8')
                ->setDescription('Wiadomość wygenerowana przez stacje pogodową w Skałągach.');
            /** @noinspection PhpParamsInspection */
            $this->container->get('mailer')->send($message);
            $findQueues = true;
        }
        if($findQueues) {
            $spool = $this->container->get('mailer')->getTransport()->getSpool();
            $transport = $this->container->get('swiftmailer.transport.real');
            $spool->flushQueue($transport);
        }
        $this->redis->lock(get_class($notify));
        return true;
    }
}
