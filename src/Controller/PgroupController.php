<?php

namespace App\Controller;

use App\Entity\Pgroup;
use App\Repository\PgroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PgroupController extends AbstractFOSRestController
{
    /**
     * @var PgroupRepository
     */
    private $pGroupRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(PgroupRepository $pGroupRepository,
                                EntityManagerInterface $entityManager)
    {

        $this->pGroupRepository = $pGroupRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/list-groups", name="list_groups")
     * @return \FOS\RestBundle\View\View
     */
    public function getGroupsAction()
    {
        $data =  $this->pGroupRepository->findAll();

        return $this->view($data, Response::HTTP_OK);
    }




    /**
     * @Route("/api/post-group", name="post_group", methods={"POST"})
     * @return \FOS\RestBundle\View\View
     * @param Request $request
     */

    public function postGroupAction(Request $request)
    {
        $pGroup = new Pgroup();
        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $price = $request->request->get('price');

        $pGroup->setName($name);
        $pGroup->setDescription($description);
        $pGroup->setPrice($price);

        $this->pGroupRepository->save($pGroup);

        return $this->view($pGroup, Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @Route("/api/group/{id}", name="get_group", methods={"GET"})
     * @return \FOS\RestBundle\View\View
     * @param Request $request
     */

    public function getGroupAction(int $id)
    {

        $data = $this->pGroupRepository->findOneBy(['id'=>$id]);

        return $this->view($data, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @Route("/api/update-group/{id}", name="update_group", methods={"PATCH"})
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */


    public function patchGroupAction(Request $request, int $id)
    {
        $pGroup = $this->pGroupRepository->findOneBy(['id'=>$id]);

        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $price = $request->request->get('price');

        if ($pGroup) {

            $pGroup->setName($name);
            $pGroup->setDescription($description);
            $pGroup->setPrice($price);

            $this->pGroupRepository->save($pGroup);

            return $this->view($pGroup, Response::HTTP_OK);
        }else{

            $errors[] = [
                'message' => 'Group record not found'
            ];
        }

        return $this->view($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param int $id
     * @Route("/api/delete-group/{id}", name="delete_group", methods={"DELETE"})
     * @param Request $request
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteGroupction(int $id)
    {
        $pGroup= $this->pGroupRepository->findOneBy(['id'=>$id]);

        $this->pGroupRepository->remove($pGroup);

        return $this->view(['message'=>'Group deleted successfully'], Response::HTTP_OK);
    }
}
