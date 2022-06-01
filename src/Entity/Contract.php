<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
     * @ORM\OneToMany(targetEntity=UserContract::class, mappedBy="contract", orphanRemoval=true)
     */
    private $users;

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
     */
    private $parent;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    /**
     * @return Collection|UserContract[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(UserContract $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setContract($this);
        }

        return $this;
    }

    public function removeUser(UserContract $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getContract() === $this) {
                $user->setContract(null);
            }
        }

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
}
