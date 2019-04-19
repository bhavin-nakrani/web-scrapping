<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     */
    public function search(Request $request)
    {
        $url = $request->get('search');
        echo $url;
        exit;
    }
}