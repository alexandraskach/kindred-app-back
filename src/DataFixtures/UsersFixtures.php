<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Contract;
use App\Entity\Mission;
use App\Entity\Rating;
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


    public function load(ObjectManager $manager,): void
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

        for ($i = 2; $i < 4; $i++) {

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
            $contract->setRatioMoney(0);
            $contract->setPointBonus(5);
            $contract->setCreatedAt(new \DateTimeImmutable());
            $contract->setParent($parent);
            $contract->setChild($child);
            $manager->persist($contract);

            // rewards
            for ($i = 0; $i < 10; $i++) {
                $reward = new Reward();
                $reward->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime dignissimos, magnam doloremque sequi error saepe eaque maiores quia enim quisquam assumenda quos laudantium eum molestiae nobis soluta voluptatum dolor! Minus.');
                $reward->setPoints(rand(5, 10) * 20);
                $reward->setUser($child);
                $manager->persist($reward);
            }

            //category

            $category = new Category();
            $category->setName("Household");
            $category->setCouleur("red");
            $manager->persist($category);

            // mission
            for ($i = 0; $i < 5; $i++) {
                $mission = new Mission();
                $mission->setTitle('Wash the dishes');
                $mission->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime dignissimos, magnam doloremque sequi error saepe eaque maiores quia enim quisquam assumenda quos laudantium eum molestiae nobis soluta voluptatum dolor! Minus.');
                $mission->setPoints(rand(5, 10) * 20);
                $mission->setIsRepeated(false);
                $mission->setCreatedAt(new \DateTimeImmutable());
                $mission->setUpdatedAt(new \DateTime());
                $mission->setStart(new \DateTimeImmutable('2022-06-27'));
                $mission->setEnd(new \DateTimeImmutable('2022-07-04'));
                $mission->setContract($contract);
                $mission->setCategory($category);
                $manager->persist($mission);
            }

            // rating
            // $rating = new Rating();
            // $rating->setParentRating(5);
            // $rating->setChildRating(5);
            // $rating->setWeek(new \DateTime("2022-06-27"));
            // $rating->setMission($mission);
            // $manager->persist($rating);

            $wallet = new Wallet();
            $wallet->setPoints(rand(150, 300));
            $wallet->setUser($child);
            $manager->persist($wallet);
        }

        $manager->flush();
    }
}
