<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parentRating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $childRating;

    /**
     * @ORM\Column(type="date")
     */
    private $week;

    /**
     * @ORM\ManyToOne(targetEntity=Mission::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mission;

    /**
     * @ORM\ManyToOne(targetEntity=Contract::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contract;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    public function getParentRating(): ?int
    {
        return $this->parentRating;
    }

    public function setParentRating(?int $parentRating): self
    {
        $this->parentRating = $parentRating;

        return $this;
    }

    public function getChildRating(): ?int
    {
        return $this->childRating;
    }

    public function setChildRating(?int $childRating): self
    {
        $this->childRating = $childRating;

        return $this;
    }

    public function getWeek(): ?\DateTimeInterface
    {
        return $this->week;
    }

    public function setWeek(\DateTimeInterface $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }
}
