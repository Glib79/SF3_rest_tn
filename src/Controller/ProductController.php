<?php // src/Controller/ProductController.php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Doctrine\ORM\EntityNotFoundException;
use App\Entity\Product;
use App\Entity\Category;

/**
 * Product controller.
 * @Route("/api")
 */
class ProductController extends FOSRestController
{
    /**
     * Create Product.
     * @param request $request
     * @FOSRest\Post("/product")
     * @throws \InvalidArgumentException
     */
    public function postProductAction(Request $request)
    {
	# get data in json format
        $data = json_decode($request->getContent());
	if (!$data) {
            throw new \InvalidArgumentException('No data in json format');
	}
	$em = $this->getDoctrine()->getManager();
	# check if category exist	
	$repository = $this->getDoctrine()->getRepository(Category::class);
	$category = $repository->findOneBy(array('name'=>$data->category));
	# if not add new one	
	if(!$category){
	    $category = new Category();
	    $category->setName($data->category);
	    $em->persist($category);
            $em->flush();
	}
        # add product
	$product = new Product();
        $product->setName($data->name);
	$product->setCategory($category);
        $product->setSku($data->sku);
	$product->setPrice($data->price);
	$product->setQuantity($data->quantity);
        $em->persist($product);
        $em->flush();

        return View::create($product, Response::HTTP_CREATED);
    }

    /**
     * Get Product.
     * @param productId $productId
     * @FOSRest\Get("/products/{productId}")
     * @throws EntityNotFoundException
     */
    public function getProductAction(int $productId)
    {
        # find product
        $repository = $this->getDoctrine()->getRepository(Product::class);
        
        $product = $repository->findById($productId);
	if (!$product) {
            throw new EntityNotFoundException('Product with id '.$productId.' does not exist!');
	}
	
	$encoders = array(new XmlEncoder(), new JsonEncoder());
	$normalizers = array(new ObjectNormalizer());

	$serializer = new Serializer($normalizers, $encoders); 
	$jsonContent = $serializer->serialize($product, 'json');
	
	return View::create($jsonContent, Response::HTTP_OK);
    }
    
    /**
     * Get Products list.
     * @FOSRest\Get("/products")
     */
    public function getProductsAction()
    {
	# get all products
        $repository = $this->getDoctrine()->getRepository(Product::class);
        
        $products = $repository->findAll();

	$encoders = array(new XmlEncoder(), new JsonEncoder());
	$normalizers = array(new ObjectNormalizer());

	$serializer = new Serializer($normalizers, $encoders); 
	$jsonContent = $serializer->serialize($products, 'json');
	
	return View::create($jsonContent, Response::HTTP_OK);
    }

    /**
     * Update Product.
     * @param productId $productId
     * @param request $request
     * @FOSRest\Put("/products/{productId}")
     * @throws EntityNotFoundException
     * @throws \InvalidArgumentException
     */
    public function putProductAction(int $productId, Request $request)
    {
	# get product
	$rep_product = $this->getDoctrine()->getRepository(Product::class);
	$product = $rep_product->findById($productId);
	if (!$product) {
            throw new EntityNotFoundException('Product with id '.$productId.' does not exist!');
	}
	$product = $product[0];
        $em = $this->getDoctrine()->getManager();
	# get data
	$data = json_decode($request->getContent());
	if (!$data) {
            throw new \InvalidArgumentException('No data in json format');
	}
	# check if category exist	
	$rep_cat = $this->getDoctrine()->getRepository(Category::class);
	$category = $rep_cat->findOneBy(array('name'=>$data->category));
	# if not add new one	
	if(!$category){
	    $category = new Category();
	    $category->setName($data->category);
	    $em->persist($category);
            $em->flush();
	}
        # update product
        $product->setName($data->name);
	$product->setCategory($category);
        $product->setSku($data->sku);
	$product->setPrice($data->price);
	$product->setQuantity($data->quantity);
        $em->persist($product);
        $em->flush();

        return View::create($product, Response::HTTP_OK);
    }
    /**
     * Delete Product.
     * @param productId $productId
     * @FOSRest\Delete("/products/{productId}")
     * @throws EntityNotFoundException
     */
    public function deleteProductAction(int $productId)
    {
	# get product
	$rep_product = $this->getDoctrine()->getRepository(Product::class);
	$product = $rep_product->findById($productId);
	if (!$product) {
            throw new EntityNotFoundException('Product with id '.$productId.' does not exist!');
	}

        $em = $this->getDoctrine()->getManager();
        $em->remove($product[0]);
        $em->flush();

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
