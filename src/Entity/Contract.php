<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ContractRepository::class)
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $ratioMoney;

    /**
     * @ORM\Column(type="integer")
     */
    private $pointBonus;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $signedAt;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="contract", orphanRemoval=true)
     * @ApiSubresource()
     */
    private $missions;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $archivedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="parentContracts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parent;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="childContract", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $child;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRatioMoney(): ?float
    {
        return $this->ratioMoney;
    }

    public function setRatioMoney(float $ratioMoney): self
    {
        $this->ratioMoney = $ratioMoney;

        return $this;
    }

    public function getPointBonus(): ?int
    {
        return $this->pointBonus;
    }

    public function setPointBonus(int $pointBonus): self
    {
        $this->pointBonus = $pointBonus;

        return $this;
    }

    public function getSignedAt(): ?\DateTimeImmutable
    {
        return $this->signedAt;
    }

    public function setSignedAt(?\DateTimeImmutable $signedAt): self
    {
        $this->signedAt = $signedAt;

        return $this;
    }

    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->setContract($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getContract() === $this) {
                $mission->setContract(null);
            }
        }

        return $this;
    }

    // public function getStatus(): ?string
    // {
    //     return $this->status;
    // }

    public function getArchivedAt(): ?\DateTimeImmutable
    {
        return $this->archivedAt;
    }

    public function setArchivedAt(\DateTimeImmutable $archivedAt): self
    {
        $this->archivedAt = $archivedAt;

        return $this;
    }

    public function getParent(): ?User
    {
        return $this->parent;
    }

    public function setParent(?User $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChild(): ?User
    {
        return $this->child;
    }

    public function setChild(User $child): self
    {
        $this->child = $child;

        return $this;
    }
}
