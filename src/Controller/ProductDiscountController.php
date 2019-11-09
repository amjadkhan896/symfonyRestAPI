<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductDiscount;
use App\Repository\ProductDiscountRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductDiscountController extends AbstractFOSRestController
{

    /**
     * @var ProductDiscountRepository
     */
    private $productDiscountRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProductRepository
     */

    private $productRepository;



    public function __construct(ProductDiscountRepository $productDiscountRepository,ProductRepository $productRepository,
                                EntityManagerInterface $entityManager)
    {

        $this->productDiscountRepository = $productDiscountRepository;
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/api/product/list-discount", name="list_product_discount")
     * @return \FOS\RestBundle\View\View
     */
    public function getProductDiscountsAction()
    {
        $data =  $this->productDiscountRepository->findAll();

        return $this->view($data, Response::HTTP_OK);
    }




    /**
     * @Route("/api/product/post-discount", name="product_discount", methods={"POST"})
     * @return \FOS\RestBundle\View\View
     * @param Request $request
     */

    public function postProductDiscountAction(Request $request)
    {
        $productDiscount = new ProductDiscount();
        $discountName = $request->request->get('discount_name');
        $discountValue = number_format((float)$request->request->get('discount_value'), 2, '.', '');

        $productDiscount->setDiscountName($discountName);
        $productDiscount->setDiscountValue($discountValue);
        $this->productDiscountRepository->save($productDiscount);

        return $this->view($productDiscount, Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @Route("/api/product/get-discount/{id}", name="get_product_discount", methods={"GET"})
     * @return \FOS\RestBundle\View\View
     * @param Request $request
     */

    public function getProductDiscountAction(int $id)
    {

        $data = $this->productDiscountRepository->findOneBy(['id'=>$id]);

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @Route("/api/product/update-discount/{id}", name="get_product_update_discount", methods={"PATCH"})
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */


    public function patchProductAction(Request $request, int $id)
    {
        $productDiscount = $this->productDiscountRepository->findOneBy(['id'=>$id]);

        $discountName = $request->request->get('discount_name');
        $discountValue = number_format((float)$request->request->get('discount_value'), 2, '.', '');


        if ($productDiscount) {

            $productDiscount->setDiscountName($discountName);
            $productDiscount->setDiscountValue($discountValue);
            $this->productDiscountRepository->save($productDiscount);

            return $this->view($productDiscount, Response::HTTP_OK);
        }else{

            $errors[] = [
                'message' => 'Discount record not found'
            ];
        }

        return $this->view($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param int $id
     * @Route("/api/product/delete-discount/{id}", name="get_product_delete_discount", methods={"DELETE"})
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteProductAction(int $id)
    {
        $disocunt= $this->productDiscountRepository->findOneBy(['id'=>$id]);

        $this->productDiscountRepository->remove($disocunt);

        return $this->view(['message'=>'Discount deleted successfully'], Response::HTTP_OK);
    }
}
