<?php

namespace App\Restaurant\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table(name="imagesmenu")
 * @ORM\Entity
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="imagesMenu_url", type="string", length=360, nullable=false)
     */
    private $fileName = '';

    /**
     * @var Restaurant
     *
     * @ORM\ManyToOne(targetEntity=Restaurant::class, inversedBy="photos")
     * @ORM\JoinColumn(name="restaurantId", nullable=false)
     */
    private $restaurant;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function markAsDeleted(): void
    {
        $this->deletedAt = new DateTime('now');
    }
}
