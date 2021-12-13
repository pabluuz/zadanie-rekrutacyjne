<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return new JsonResponse($serializer->serialize($itemRepository->findAll(), 'json'), Response::HTTP_OK, [],
            true);
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

            return new JsonResponse(['status' => 'ok'], Response::HTTP_OK, [], true);
        } catch (\Throwable $exception) {

            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST, [], true);
        }
    }

    /**
     * @Route("/show/{id}", name="item_show", methods={"GET"})
     * @param Item $item
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function show(Item $item, SerializerInterface $serializer): Response
    {

        return new JsonResponse($serializer->serialize($item, 'json'), Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/edit/{id}", name="item_edit", methods={"PUT"})
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
     * @Route("/delete/{id}", name="item_delete", methods={"DELETE"})
     * @param Item $item
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(Item $item, EntityManagerInterface $entityManager): Response
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
     * @Route("/find", name="item_find", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @return Response
     *
     * Kandydat do refaktoru. Header findBy fajnie by było chociaż walidować.
     * Dodatkowo find powinno używać GETa, aby w pełni być RESTem
     * See: https://www.vinaysahni.com/best-practices-for-a-pragmatic-restful-api#restful
     */
    public function find(
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response {
        try {
            $findBy = $request->headers->get('findBy');
            $value = $request->headers->get('value');
            if ($findBy === "statusHistory") {
                $statusType = $entityManager->getRepository('App:StatusType')->findOneBy(["name" => $value]);
                $items = $entityManager->getRepository('App:Item')->findByStatusTypeInStatusHistory($statusType);
            } elseif ($findBy === "createdAt" || $findBy === "modifiedAt") {
                $items = $entityManager->getRepository('App:Item')->findBy([$findBy => new DateTimeImmutable($value)]);
            } else {
                $items = $entityManager->getRepository('App:Item')->findBy([$findBy => $value]);
            }

            return new JsonResponse($serializer->serialize($items, 'json'), Response::HTTP_OK, [], true);
        } catch (\Throwable $exception) {

            return new JsonResponse(['status' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
