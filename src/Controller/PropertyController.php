<?php
/**
 * Created by PhpStorm.
 * User: Joe
 * Date: 12/03/2019
 * Time: 14:22
 */

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    public function __construct(PropertyRepository $repository,ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="property.index")
     */
    public function index()
    {

        return $this->render('property/index.html.twig', array(
            'current_menu' => 'propreties',
        ));
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string  $slug): Response
    {
        if ($property->getSlug() !== $slug)
        {
           return $this->redirectToRoute('property.show', [
                    'id' => $property->getId(),
                    'slug' => $property->getSlug(),
            ],301);
        }
        return $this->render('property/show.html.twig', array(
            'current_menu' => 'propreties',
            'property' => $property,
        ));
    }
}