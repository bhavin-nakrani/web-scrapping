<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Url as UrlConstraint;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

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

        /* Validation Start */
        $validator = Validation::createValidator();
        $violations = $validator->validate($url, [
            new UrlConstraint(),
        ]);

        if (0 !== count($violations)) {
            // there are errors, now you can show them
            foreach ($violations as $violation) {
                echo $violation->getMessage().'<br>';
            }

            $this->redirectToRoute('homepage');
        }
        /* Validation End */

        $client = new Client();
        $crawler = $client->request('GET', $url);
        $links_count = $crawler->filter('a')->count();
        $all_links = []; $i=0;
        if($links_count > 0){
            $links = $crawler->filter('a')->links();

            foreach ($links as $link) {

                //if ($i > 10) { break;}
                $all_links[] = $link->getURI();
                $i++;
            }

            $all_links = array_unique($all_links);
        }

        return $this->render('search.html.twig', ['all_links' => $all_links]);
    }

    private function extractEmails ($string){

        $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
        preg_match_all($pattern, $string, $matches);
        print_r($matches[0]);
    }
}