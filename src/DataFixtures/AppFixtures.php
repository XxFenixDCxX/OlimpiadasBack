<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Entity\Zones;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $zone0 = new Zones();
        $zone0->setStart(new \DateTime('2024-04-01 24:00:00'));
        $zone0->setEnd(new \DateTime('2024-04-7 24:00:00'));
        $manager->persist($zone0);

        $zone1 = new Zones();
        $zone1->setStart(new \DateTime('2024-04-08 24:00:00'));
        $zone1->setEnd(new \DateTime('2024-04-14 24:00:00'));
        $manager->persist($zone1);

        $zone2 = new Zones();
        $zone2->setStart(new \DateTime('2024-04-15 24:00:00'));
        $zone2->setEnd(new \DateTime('2024-04-21 24:00:00'));
        $manager->persist($zone2);

        $zone3 = new Zones();
        $zone3->setStart(new \DateTime('2024-04-22 24:00:00'));
        $zone3->setEnd(new \DateTime('2024-04-28 24:00:00'));
        $manager->persist($zone3);

        $zone4 = new Zones();
        $zone4->setStart(new \DateTime('2024-05-06 24:00:00'));
        $zone4->setEnd(new \DateTime('2024-05-12 24:00:00'));
        $manager->persist($zone4);

        $zone5 = new Zones();
        $zone5->setStart(new \DateTime('2024-05-13 24:00:00'));
        $zone5->setEnd(new \DateTime('2024-05-19 24:00:00'));
        $manager->persist($zone5);

        $zone6 = new Zones();
        $zone6->setStart(new \DateTime('2024-05-20 24:00:00'));
        $zone6->setEnd(new \DateTime('2024-05-26 24:00:00'));
        $manager->persist($zone6);

        $zone7 = new Zones();
        $zone7->setStart(new \DateTime('2024-05-27 24:00:00'));
        $zone7->setEnd(new \DateTime('2024-06-02 24:00:00'));
        $manager->persist($zone7);

        $user = new Users();
        $user->setSub("auth0|660140be6ea7bff45010335a");
        $user->setEmail("arkaitzcs@gmail.com");
        $user->setUsername("arkaitzcs");
        $user->addZone($zone0);
        $user->addZone($zone1);
        $manager->persist($user);

        $manager->flush();
    }
}
