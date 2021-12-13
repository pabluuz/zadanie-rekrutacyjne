<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/item")
 * Controller uses no validation, and it's really unsafe. It's just for purpose of recruitment task.
 */
class ItemController extends AbstractController
{
    /**
     * @Route("/", name="item_index", methods={"GET"})
     * @param ItemRepository $itemRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index(ItemRepository $itemRepository, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse($serializer->serialize($itemRepository->findAll(), 'json'), Response::HTTP_OK);
    }

    /**
     * @Route("/new", name="item_new", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response {
        try {
            $item = $serializer->deserialize($request->getContent(), Item::class, 'json');
            $entityManager->persist($item);
            $entityManager->flush();

            return new JsonResponse(['status' => 'ok'], Response::HTTP_OK);
        } catch (\Throwable $exception) {

            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/{id}", name="item_show", methods={"GET"})
     * @param Item $item
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function show(Item $item, SerializerInterface $serializer): Response
    {

        return new JsonResponse($serializer->serialize($item, 'json'), Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/edit", name="item_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Item $item
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function edit(
        Request $request,
        Item $item,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response {
        try {
            $itemNew = $serializer->deserialize($request->getContent(), Item::class, 'json');
            /** @var $itemNew Item */
            $item
                ->setName($itemNew->getName())
                ->setStatusType($itemNew->getStatusType())
                ->setNumber($itemNew->getNumber());
            $entityManager->persist($item);
            $entityManager->flush();

            return new JsonResponse(['status' => 'ok'], Response::HTTP_OK);
        } catch (\Throwable $exception) {

            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/{id}", name="item_delete", methods={"POST"})
     * @param Item $item
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function delete(Item $item, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            $entityManager->remove($item);
            $entityManager->flush();

            return new JsonResponse(['status' => 'ok'], Response::HTTP_OK);
        } catch (\Throwable $exception) {

            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/find", name="item_find", methods={"GET", "POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function find(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        try {
            $findBy = $request->get('findBy');
            $value = $request->get('value');
            $item = $entityManager->getRepository('Item')->findOneBy([$findBy => $value]);

            return new JsonResponse($serializer->serialize($item, 'json'), Response::HTTP_OK);
        } catch (\Throwable $exception) {

            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
