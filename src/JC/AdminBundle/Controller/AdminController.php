<?php

namespace JC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('JCAdminBundle:Admin:index.html.twig');
    }
}
