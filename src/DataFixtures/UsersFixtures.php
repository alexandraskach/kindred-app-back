<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use App\Entity\Reward;
use App\Entity\User;
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
        // parent
        $parent = new User();
        $parent->setFirstName('Lorem');
        $parent->setLastName('Ipsum');
        $parent->setEmail('parent@mail.com');
        $parent->setPassword($this->passwordHasher->hashPassword($parent, 'password'));
        $parent->setCreatedAt(new \DateTimeImmutable());
        $parent->setUpdatedAt(new \DateTime());
        $manager->persist($parent);

        // rewards
        for ($i = 0; $i < 10; $i++) {
            $reward = new Reward();
            $reward->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime dignissimos, magnam doloremque sequi error saepe eaque maiores quia enim quisquam assumenda quos laudantium eum molestiae nobis soluta voluptatum dolor! Minus.');
            $reward->setPoints(rand(5,10) * 20);
            $reward->setUser($parent);
            $manager->persist($reward);
        }

        for($i = 2; $i < 4; $i++) {
            
            // wallet
            $wallet = new Wallet();
            $wallet->setPoints(0);
            $manager->persist($wallet);

            // child
            $child = new User();
            $child->setFirstName('usr' . $i);
            $child->setLastName('child');
            $child->setEmail('child' . $i - 1 . '@mail.com');
            $child->setPassword($this->passwordHasher->hashPassword($child, 'password'));
            $child->setWallet($wallet);
            $child->setCreatedAt(new \DateTimeImmutable());
            $child->setUpdatedAt(new \DateTime());
            $child->setParent($parent);
            $manager->persist($child);

            // contract
            $contract = new Contract();
            $contract->setDescription('contract description');
            $contract->setRatioMoney(0.5);
            $contract->setPointBonus(5);
            $contract->setCreatedAt(new \DateTimeImmutable());
            $contract->setParent($parent);
            $contract->setChild($child);
            $manager->persist($contract);
        }

        $manager->flush();
    }
}
