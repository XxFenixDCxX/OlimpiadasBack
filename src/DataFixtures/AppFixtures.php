<?php

namespace App\DataFixtures;

use App\Entity\Zones;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $zone0 = new Zones();
        $zone0->setStart(new \DateTime('2021-04-01'));
        $zone0->setEnd(new \DateTime('2021-04-7'));
        $manager->persist($zone0);

        $zone1 = new Zones();
        $zone1->setStart(new \DateTime('2021-04-08'));
        $zone1->setEnd(new \DateTime('2021-04-14'));
        $manager->persist($zone1);

        $zone2 = new Zones();
        $zone2->setStart(new \DateTime('2021-04-15'));
        $zone2->setEnd(new \DateTime('2021-04-21'));
        $manager->persist($zone2);

        $zone3 = new Zones();
        $zone3->setStart(new \DateTime('2021-04-22'));
        $zone3->setEnd(new \DateTime('2021-04-28'));
        $manager->persist($zone3);

        $zone4 = new Zones();
        $zone4->setStart(new \DateTime('2021-05-06'));
        $zone4->setEnd(new \DateTime('2021-05-12'));
        $manager->persist($zone4);

        $zone5 = new Zones();
        $zone5->setStart(new \DateTime('2021-05-13'));
        $zone5->setEnd(new \DateTime('2021-05-19'));
        $manager->persist($zone5);

        $zone6 = new Zones();
        $zone6->setStart(new \DateTime('2021-05-20'));
        $zone6->setEnd(new \DateTime('2021-05-26'));
        $manager->persist($zone6);

        $zone7 = new Zones();
        $zone7->setStart(new \DateTime('2021-05-27'));
        $zone7->setEnd(new \DateTime('2021-06-02'));
        $manager->persist($zone7);

        $manager->flush();
    }
}
