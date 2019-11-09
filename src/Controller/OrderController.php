<?php

namespace App\Controller;

use App\Entity\OrderDetails;
use App\Repository\OrderDetailsRepository;
use App\Repository\PgroupRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractFOSRestController
{
    /**
     * @var PgroupRepository
     */
    private $pGroupRepository;

    /**
     *
     */
    private $orderDetailsRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProductRepository
     */

    private $productRepository;


    public function __construct(OrderDetailsRepository $orderDetailsRepository,
                                ProductRepository $productRepository, PgroupRepository $pGroupRepository,
                                EntityManagerInterface $entityManager)
    {

        $this->orderDetailsRepository = $orderDetailsRepository;
        $this->pGroupRepository = $pGroupRepository;
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/api/list-orders", name="list_orders")
     * @return \FOS\RestBundle\View\View
     */
    public function getOrdersAction()
    {
        $data = $this->orderDetailsRepository->findAll();

        return $this->view($data, Response::HTTP_OK);
    }


    /**
     * @Route("/api/post-order", name="post_order", methods={"POST"})
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */

    public function postOrderAction(Request $request)
    {
        $message='';
        if(!empty($request->request->get('group_id'))){

            $groupId = $request->request->get('group_id');
            $group = $this->pGroupRepository->findOneById(['id' => $groupId]);
            if(count($group->getGroupProducts())>0){

                $discount = 0;
                $quantity = $request->request->get('quantity');
                $chargedPrice = number_format((float)$group->getPrice(), 2, '.', '') * (int)$quantity;

                $totalPrice = $chargedPrice;
                $status = $request->request->get('status');

                $order = new OrderDetails();
                $order->setProductsGroup($group);
                $order->setQuantity($quantity);
                $order->setDiscount($discount);
                $order->setChargedPrice($chargedPrice);
                $order->setTotalPrice($totalPrice);
                $order->setStatus($status);
                $order->setStatus($status);

                $this->orderDetailsRepository->save($order);

                $message = ['message'=>"Order added successfully"];
            }else{
                $message = ['message'=>"Group does not contain products"];
            }


        }else {

            $productId = $request->request->get('product_id');
            $product = $this->productRepository->findOneById(['id' => $productId]);


            $discount = !empty($product->getProductDiscount()) ? number_format((float)$product->getProductDiscount()->getDiscountValue(), 2, '.', '') : '';

            $quantity = $request->request->get('quantity');
            $chargedPrice = number_format((float)$product->getPrice(), 2, '.', '') * (int)$quantity;

            $totalPrice = $chargedPrice - ($chargedPrice * $discount);
            $status = $request->request->get('status');

            $order = new OrderDetails();
            $order->setProduct($product);
            $order->setQuantity($quantity);
            $order->setDiscount($discount);
            $order->setChargedPrice($chargedPrice);
            $order->setTotalPrice($totalPrice);
            $order->setStatus($status);
            $order->setStatus($status);

            $this->orderDetailsRepository->save($order);
            $message = ['message'=>"Order added successfully"];
        }

        return $this->view($message, Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @Route("/api/get-order/{id}", name="get_order", methods={"GET"})
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */

    public function getOrderAction(int $id)
    {

        $data = $this->orderDetailsRepository->findOneBy(['id' => $id]);

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @Route("/api/update-order/{id}", name="update_order", methods={"PATCH"})
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */


    public function patchOrderAction(Request $request, int $id)
    {
        $order= $this->orderDetailsRepository->findOneBy(['id' => $id]);

        $message='';

        if(!empty($request->request->get('group_id'))){

            $groupId = $request->request->get('group_id');
            $group = $this->pGroupRepository->findOneById(['id' => $groupId]);


            if($order->getProductsGroup()->getId()!=$groupId){

                $message = ['message'=>"Wrong Group Id supplied Record not found"];
            }

            if(count($group->getGroupProducts())>0){

                $discount = 0;
                $quantity = $request->request->get('quantity');
                $chargedPrice = number_format((float)$group->getPrice(), 2, '.', '') * (int)$quantity;

                $totalPrice = $chargedPrice;


                $order->setProductsGroup($group);
                $order->setQuantity($quantity);
                $order->setDiscount($discount);
                $order->setChargedPrice($chargedPrice);
                $order->setTotalPrice($totalPrice);

                $this->orderDetailsRepository->save($order);

                $message = ['message'=>"Order updated successfully"];
            }else{
                $message = ['message'=>"Group does not contain products"];
            }


        }else {

            $productId = $request->request->get('product_id');
            $product = $this->productRepository->findOneById(['id' => $productId]);

            if($order->getProduct()->getId()!=$productId){

                $message = ['message'=>"Wrong product Id supplied Record not found"];
            }


            $discount = !empty($product->getProductDiscount()) ? number_format((float)$product->getProductDiscount()->getDiscountValue(), 2, '.', '') : '';

            $quantity = $request->request->get('quantity');
            $chargedPrice = number_format((float)$product->getPrice(), 2, '.', '') * (int)$quantity;

            $totalPrice = $chargedPrice - ($chargedPrice * $discount);

            $order->setProduct($product);
            $order->setQuantity($quantity);
            $order->setDiscount($discount);
            $order->setChargedPrice($chargedPrice);
            $order->setTotalPrice($totalPrice);

            $this->orderDetailsRepository->save($order);
            $message = ['message'=>"Order updated successfully"];
        }

        return $this->view($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param int $id
     * @Route("/api/delete-order/{id}", name="delete_order", methods={"DELETE"})
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteOrderAction(int $id)
    {
        $disocunt = $this->orderDetailsRepository->findOneBy(['id' => $id]);

        $this->orderDetailsRepository->remove($disocunt);

        return $this->view(['message' => 'Order deleted successfully'], Response::HTTP_OK);
    }
}
