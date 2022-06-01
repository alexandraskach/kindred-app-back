<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use App\Entity\User;
use App\Entity\UserContract;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager, ): void
    {

        $contract = new Contract();
        $contract->setDescription('contract description');
        $contract->setRatioMoney(0.5);
        $contract->setPointBonus(5);
        $contract->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($contract);

        // Parent 1
        $parent = new User();
        $parent->setFirstName('usr1');
        $parent->setLastName('parent');
        $parent->setEmail('parent@mail.com');
        $parent->setPassword($this->passwordHasher->hashPassword($parent, 'password'));
        $parent->addContractAvailable($contract);
        $parent->setCreatedAt(new \DateTimeImmutable());
        $parent->setUpdatedAt(new \DateTime());
        $manager->persist($parent);

        for($i = 2; $i < 4; $i++) {
            $wallet = new Wallet();
            $wallet->setPoints(0);
            $manager->persist($wallet);

            $userContract = new UserContract();
            $userContract->setContract($contract);
            $userContract->setSignedAt(new \DateTimeImmutable());
            $userContract->setIsExpired(false);
            $manager->persist($userContract);

            $child = new User();
            $child->setFirstName('usr' . $i);
            $child->setLastName('child');
            $child->setEmail('child' . $i -1  . '@mail.com');
            $child->setPassword($this->passwordHasher->hashPassword($child, 'password'));
            $child->addContract($userContract);
            $child->setWallet($wallet);
            $child->setCreatedAt(new \DateTimeImmutable());
            $child->setUpdatedAt(new \DateTime());
            $manager->persist($child);
        }
        $manager->flush();
    }
}
