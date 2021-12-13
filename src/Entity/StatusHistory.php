<?php

namespace App\Entity;

use App\Repository\StatusHistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=StatusHistoryRepository::class)
 */
class StatusHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @Serializer\Exclude
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="statusHistory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity=StatusType::class, inversedBy="statusHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statusType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getStatusType(): ?StatusType
    {
        return $this->statusType;
    }

    public function setStatusType(?StatusType $statusType): self
    {
        $this->statusType = $statusType;

        return $this;
    }
}
