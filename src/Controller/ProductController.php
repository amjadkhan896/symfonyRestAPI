<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductDiscountRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractFOSRestController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductDiscountRepository
     */
    private $productDiscountRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ProductRepository $productRepository, ProductDiscountRepository $productDiscountRepository,
                                EntityManagerInterface $entityManager)
    {

        $this->productRepository = $productRepository;
        $this->productDiscountRepository = $productDiscountRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return \FOS\RestBundle\View\View
     */

    public function getProductsAction()
    {
        $data =  $this->productRepository->findAll();

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @param Request $request
     */

    public function postProductsAction(Request $request)
    {
        $product = new Product();
        $name = $request->request->get('name');
        $productDiscount = $request->request->get('product_discount_id');
        $description= $request->request->get('description');
        $price= $request->request->get('price');
        $quantity= $request->request->get('quantity');


        $product->setName($name);
        if($productDiscount!=''){
            $product->setProductDiscount($this->productDiscountRepository->findOneBy(['id'=> $productDiscount]) );
        }
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setQuantity($price);

        $this->productRepository->save($product);


        return $this->view($product, Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     */

    public function getProductAction(int $id)
    {

        $data = $this->productRepository->findOneBy(['id'=>$id]);

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */


    public function patchProductAction(Request $request, int $id)
    {
        $product = $this->productRepository->findOneBy(['id'=>$id]);
        $name = $request->request->get('name');
        $productDiscount = $request->request->get('product_discount_id');
        $description = $request->request->get('description');
        $price = $request->request->get('price');
        $quantity= $request->request->get('quantity');


            if ($product) {
                $product->setName($name);
                if($productDiscount!=''){
                    $product->setProductDiscount($this->productDiscountRepository->findOneBy(['id'=> $productDiscount]) );
                }
                $product->setDescription($description);
                $product->setPrice($price);
                $product->setQuantity($price);
                
                $this->productRepository->save($product);

                return $this->view($product, Response::HTTP_OK);
            }else{

            $errors[] = [
                'message' => 'Product not found'
            ];
        }

        return $this->view($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function deleteProductAction(int $id)
    {

        $product= $this->productRepository->findOneBy(['id'=>$id]);

        $this->productRepository->remove($product);


        return $this->view(['message'=>'product deleted successfully'], Response::HTTP_OK);
    }


}
