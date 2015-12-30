<?php

namespace SyntaxError\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function loggedAction()
    {
        $admin = $this->get('syntax_error_api.admin');

        return $this->render('SyntaxErrorApiBundle:Admin:logged.html.twig', [
            'hardware' => $admin->createHardwareInformer(),
            'database' => $admin->createDatabaseInformer(),
            'redis' => $admin->createRedisInformer(),
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
