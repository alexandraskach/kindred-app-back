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
        $faker = \Faker\Factory::create('fr_FR');




        // Parent 1
        $parent = new User();
        $parent->setFirstName('usr1');
        $parent->setLastName('parent');
        $parent->setEmail('parent@mail.com');
        $parent->setPassword($this->passwordHasher->hashPassword($parent, 'password'));
        $parent->setCreatedAt(new \DateTimeImmutable());
        $parent->setUpdatedAt(new \DateTime());
        $manager->persist($parent);

        // rewards
        for ($i = 0; $i < 10; $i++) {
            $reward = new Reward();
            $reward->setDescription($faker->sentence);
            $reward->setPoints(10+ 3 *$i);
            $reward->setUser($parent);
            $manager->persist($reward);
        }
        for($i = 2; $i < 4; $i++) {
            $contract = new Contract();
            $contract->setDescription('contract description');
            $contract->setRatioMoney(0.5);
            $contract->setPointBonus(5);
            $contract->setStatus(Contract::$DRAFT);
            $contract->setCreatedAt(new \DateTimeImmutable());
            $contract->setParent($parent);
            $manager->persist($parent);
            $manager->persist($contract);

            $wallet = new Wallet();
            $wallet->setPoints(0);
            $manager->persist($wallet);


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
            $contract->setUser($child);
            $manager->persist($contract);

        }
        $manager->flush();
    }
}
