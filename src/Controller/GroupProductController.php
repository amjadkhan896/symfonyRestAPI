<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\PgroupRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupProductController extends AbstractFOSRestController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var PgroupRepository
     */
    private $pgroupRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;



    public function __construct(ProductRepository $productRepository, PgroupRepository $pgroupRepository,
                                EntityManagerInterface $entityManager)
    {

        $this->productRepository = $productRepository;
        $this->pgroupRepository = $pgroupRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/list-group-products", name="list_group_products")
     * @return \FOS\RestBundle\View\View
     */

    public function getGroupProductsAction()
    {
        $data =  $this->pgroupRepository->findAll();

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/post-group-product", name="post_group_product", methods={"POST"})
     * @return \FOS\RestBundle\View\View
     * @param Request $request
     */

    public function postGroupProductAction(Request $request)
    {
        /** @var Group  $group*/
        $group = $request->request->get('group_id');
        $productsArr = $request->request->get('product_id');
        $pGroup = $this->pgroupRepository->findOneById($group);


        foreach($productsArr as $product){
            // Code to be executed
            $aProduct = $this->productRepository->findOneById($product);
            if($aProduct){
                $aProduct->addProductsGroup($pGroup);
                $pGroup->addGroupProduct($aProduct);
                $this->entityManager->persist($aProduct);

                $this->entityManager->flush();
            }

        }




        return $this->view(['message'=>"Group Product created successfully"], Response::HTTP_CREATED);
    }


    /**
     * @param int $id
     * @Route("/api/get-group-product/{id}", name="get_group_product", methods={"GET"})
     * @return \FOS\RestBundle\View\View
     * @param Request $request
     */

    public function getGroupProductAction(int $id)
    {

        $data = $this->pgroupRepository->findOneBy(['id'=>$id]);

        return $this->view($data, Response::HTTP_OK);
    }



    /**
     * @param int $id
     * @Route("/api/update-group-product/{id}", name="update_group_product", methods={"PUT"})
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */


    public function putGroupProductAction(Request $request, int $id)
    {
        /** @var Group  $group*/
        $pGroup = $this->pgroupRepository->findOneById(['id'=>$id]);

        $groupProductsArr = $pGroup->getGroupProducts($pGroup);

        foreach($groupProductsArr as $product){
             $pGroup->removeGroupProduct($product);
             $this->entityManager->flush();

        }

        $productsArr = $request->request->get('product_id');


        foreach($productsArr as $product){
            // Code to be executed
            $aProduct = $this->productRepository->findOneById($product);
            if($aProduct){
                $aProduct->addProductsGroup($pGroup);
                $pGroup->addGroupProduct($aProduct);
                $this->entityManager->persist($aProduct);

                $this->entityManager->flush();
            }

        }




        return $this->view(['message'=>"Group Product updated successfully"], Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @Route("/api/delete-group-product/{id}", name="delete_group_products", methods={"DELETE"})
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteGroupProductsAction(int $id)
    {
        /** @var Group  $group*/
        $pGroup = $this->pgroupRepository->findOneById(['id'=>$id]);

        $groupProductsArr = $pGroup->getGroupProducts($pGroup);

        foreach($groupProductsArr as $product){
            $pGroup->removeGroupProduct($product);
            $this->entityManager->flush();

        }

        return $this->view(['message'=>'Group deleted successfully'], Response::HTTP_OK);
    }





}
