<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\CurrentUserController;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use function Symfony\Component\String\b;

/**
 * @ApiResource(
 *  collectionOperations={
 *      "get" = {"normalization_context" = {"groups" = "User:Collection:Get"}},
 *     "post",
 *      "current_user"={"path"="/current_user", "method"="get", "controller"=CurrentUserController::class},
 *  })
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public $passwordHasher;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"User:Collection:Get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"User:Collection:Get"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"User:Collection:Get"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:Collection:Get"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:Collection:Get"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:Collection:Get"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"User:Collection:Get"})
     */
    private $token;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @Groups({"User:Collection:Get"})
     */
    private $expiredAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"User:Collection:Get"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"User:Collection:Get"})
     */
    private $updatedAt;


    /**
     * @ORM\OneToOne(targetEntity=Wallet::class, inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @ApiSubresource()
     * @Groups({"User:Collection:Get"})
     */
    private $wallet;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="childs")
     * @ApiSubresource()
     * @Groups({"User:Collection:Get"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="parent")
     * @ApiSubresource()
     * @Groups({"User:Collection:Get"})
     */
    private $childs;

    /**
     * @ORM\OneToMany(targetEntity=Reward::class, mappedBy="user", orphanRemoval=true)
     * @ApiSubresource()
     * @Groups({"User:Collection:Get"})
     */
    private $rewards;

    /**
     * @ORM\OneToMany(targetEntity=Contract::class, mappedBy="parent", orphanRemoval=true)
     */
    private $parentContracts;

    /**
     * @ORM\OneToOne(targetEntity=Contract::class, mappedBy="child", cascade={"persist", "remove"})
     */
    private $childContract;

    public function __construct()
    {
        $this->childs = new ArrayCollection();
        $this->rewards = new ArrayCollection();
        $this->parentContracts = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(?\DateTimeImmutable $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

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

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(self $child): self
    {
        if (!$this->childs->contains($child)) {
            $this->childs[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->childs->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reward>
     */
    public function getRewards(): Collection
    {
        return $this->rewards;
    }

    public function addReward(Reward $reward): self
    {
        if (!$this->rewards->contains($reward)) {
            $this->rewards[] = $reward;
            $reward->setUser($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): self
    {
        if ($this->rewards->removeElement($reward)) {
            // set the owning side to null (unless already changed)
            if ($reward->getUser() === $this) {
                $reward->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contract>
     */
    public function getParentContracts(): Collection
    {
        return $this->parentContracts;
    }

    public function addParentContract(Contract $parentContract): self
    {
        if (!$this->parentContracts->contains($parentContract)) {
            $this->parentContracts[] = $parentContract;
            $parentContract->setParent($this);
        }

        return $this;
    }

    public function removeParentContract(Contract $parentContract): self
    {
        if ($this->parentContracts->removeElement($parentContract)) {
            // set the owning side to null (unless already changed)
            if ($parentContract->getParent() === $this) {
                $parentContract->setParent(null);
            }
        }

        return $this;
    }

    public function getChildContract(): ?Contract
    {
        return $this->childContract;
    }

    public function setChildContract(Contract $childContract): self
    {
        // set the owning side of the relation if necessary
        if ($childContract->getChild() !== $this) {
            $childContract->setChild($this);
        }

        $this->childContract = $childContract;

        return $this;
    }
}
