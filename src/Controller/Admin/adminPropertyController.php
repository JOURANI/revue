<?php
/**
 * Created by PhpStorm.
 * User: Joe
 * Date: 19/03/2019
 * Time: 18:32
 */

namespace App\Controller\Admin;


use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class adminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index ()
    {
        $properties = $this->repository->findAll();
        return $this->render('Admin/property/index.html.twig',compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Bien créer avec success');

            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('Admin/property/new.html.twig', array(
            'property' => $property,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/edit/{id}", name="admin.property.edit")
     * @param Property $property
     */
    public function edit(Property $property, Request $request)
    {
       $form = $this->createForm(PropertyType::class, $property);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid())
       {
           $this->em->flush();
           $this->addFlash('success','Bien modifier avec success');
           return $this->redirectToRoute('admin.property.index');
       }
        return $this->render('Admin/property/edit.html.twig', array(
            'property' => $property,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/delete/{id}", name="admin.property.delete")
     */
    public function delete(Property $property, Request $request)
    {

            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success','Suppression avec success');


        return $this->redirectToRoute('admin.property.index');
    }
}