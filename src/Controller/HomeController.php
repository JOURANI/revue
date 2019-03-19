<?php
/**
 * Created by PhpStorm.
 * User: Joe
 * Date: 12/03/2019
 * Time: 12:32
 */

namespace App\Controller;


use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(PropertyRepository $repository)
    {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', array(
            'properties'=> $properties,
        ));
    }
}