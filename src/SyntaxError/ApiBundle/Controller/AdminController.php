<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SyntaxError\ApiBundle\Tools\Jsoner;
use SyntaxError\SocketBundle\Server\Config;

class AdminController extends Controller
{
    public function loggedAction(Request $request)
    {
        if( $request->query->has('ws_action') ) {
            switch($request->query->get('ws_action')) {
                case 'start':
                    $serverPath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "SocketBundle" . DIRECTORY_SEPARATOR . "app.php";
                    `php $serverPath > /dev/null 2>/dev/null &`;
                    return $this->redirectToRoute( $request->attributes->get('_route') );
                default:
                    $pid = Config::getPid();
                    `kill $pid`;
                    file_put_contents(__DIR__. DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "SocketBundle" . DIRECTORY_SEPARATOR . ".pid", 'stopped');
                    return $this->redirectToRoute( $request->attributes->get('_route') );
            }
        }
        $admin = $this->get('syntax_error_api.admin');

        if( $request->isXmlHttpRequest() ) {
            $jsoner = new Jsoner();
            $jsoner->createJson( $admin->createSocketInformer() );
            return $jsoner->createResponse(null);
        }

        return $this->render('SyntaxErrorApiBundle:Admin:logged.html.twig', [
            'hardware' => $admin->createHardwareInformer(),
            'database' => $admin->createDatabaseInformer(),
            'server' => $admin->createServerInformer(),
            'socket' => $admin->createSocketInformer()
        ]);
    }

    public function loginAction()
    {
        if( $this->isGranted('ROLE_ADMIN') ) {
            return $this->redirectToRoute('syntax_error_api_admin_logged');
        }
        $utils = $this->get('security.authentication_utils');

        return $this->render('SyntaxErrorApiBundle:Admin:login.html.twig', [
            'lastUserName' => $utils->getLastUsername(),
            'authError' => $utils->getLastAuthenticationError()
        ]);
    }

    public function loginCheckAction()
    {
    }
}
