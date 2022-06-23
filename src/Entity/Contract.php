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
    private $ratio_money;

    /**
     * @ORM\Column(type="integer")
     */
    private $point_bonus;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contractAvailable")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource()
     */
    private $parent;


    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $signed_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource()
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="contract", orphanRemoval=true)
     */
    private $missions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $archived_at;



    static string $AVAILABLE = 'available';
    static string $DRAFT = 'draft';
    static string $SIGNED = 'signed';
    static string $ARCHIVED = 'archived';

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
        return $this->ratio_money;
    }

    public function setRatioMoney(float $ratio_money): self
    {
        $this->ratio_money = $ratio_money;

        return $this;
    }

    public function getPointBonus(): ?int
    {
        return $this->point_bonus;
    }

    public function setPointBonus(int $point_bonus): self
    {
        $this->point_bonus = $point_bonus;

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

    public function getSignedAt(): ?\DateTimeImmutable
    {
        return $this->signed_at;
    }

    public function setSignedAt(?\DateTimeImmutable $signed_at): self
    {
        $this->signed_at = $signed_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function hasStatut(string $status): bool
    {
        return $this->status == $status;
    }

    public function getArchivedAt(): ?\DateTimeImmutable
    {
        return $this->archived_at;
    }

    public function setArchivedAt(\DateTimeImmutable $archived_at): self
    {
        $this->archived_at = $archived_at;

        return $this;
    }

}
