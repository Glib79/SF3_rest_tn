<?php // src/Controller/CategoryController.php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Category;

/**
 * Category controller.
 */
class CategoryController extends FOSRestController
{
    /**
     * Get Categories list.
     * @FOSRest\Get("/categories")
     */
    public function getCategoriesAction()
    {
	# get all categories
        $repository = $this->getDoctrine()->getRepository(Category::class);
        
        $categories = $repository->findAll();

	$encoders = array(new XmlEncoder(), new JsonEncoder());
	$normalizers = array(new ObjectNormalizer());

	$serializer = new Serializer($normalizers, $encoders); 
	$jsonContent = $serializer->serialize($categories, 'json');
	
	return View::create($jsonContent, Response::HTTP_OK);
    }
}
