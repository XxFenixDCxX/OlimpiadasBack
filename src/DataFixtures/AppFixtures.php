<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Section;
use App\Entity\Users;
use App\Entity\Zones;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Agregadas zonas por defecto
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

        //Agregados eventos por defecto
        $atletismo = new Event();
        $atletismo->setTitle('Atletismo');
        $atletismo->setDescription('Salto y velocidad');
        $atletismo->setImage("https://olympics.com/images/static/sports/pictograms/v2/ath.svg");
        $atletismo->setDate(new \DateTime('2024-06-01 18:00:00'));
        $manager->persist($atletismo);
        
        $section1 = new Section();
        $section1->setDescription('Sección 1');
        $section1->setSlots(100);
        $section1->setPrice(150);
        $section1->setEvent($atletismo);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setDescription('Sección 2');
        $section2->setSlots(100);
        $section2->setPrice(120);
        $section2->setEvent($atletismo);
        $manager->persist($section2);

        $section3 = new Section();
        $section3->setDescription('Sección 3');
        $section3->setSlots(100);
        $section3->setPrice(110);
        $section3->setEvent($atletismo);
        $manager->persist($section3);

        $section4 = new Section();
        $section4->setDescription('Sección 4');
        $section4->setSlots(100);
        $section4->setPrice(100);
        $section4->setEvent($atletismo);
        $manager->persist($section4);

        $baloncesto = new Event();
        $baloncesto->setTitle('Baloncesto');
        $baloncesto->setDescription('Estrategia y dribbling');
        $baloncesto->setImage("https://olympics.com/images/static/sports/pictograms/v2/bkb.svg");
        $baloncesto->setDate(new \DateTime('2024-06-15 16:00:00'));
        $manager->persist($baloncesto);

        $section1 = new Section();
        $section1->setDescription('Sección 1');
        $section1->setSlots(100);
        $section1->setPrice(100);
        $section1->setEvent($baloncesto);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setDescription('Sección 2');
        $section2->setSlots(100);
        $section2->setPrice(90);
        $section2->setEvent($baloncesto);
        $manager->persist($section2);

        $section3 = new Section();
        $section3->setDescription('Sección 3');
        $section3->setSlots(100);
        $section3->setPrice(80);
        $section3->setEvent($baloncesto);
        $manager->persist($section3);

        $section4 = new Section();
        $section4->setDescription('Sección 4');
        $section4->setSlots(100);
        $section4->setPrice(70);
        $section4->setEvent($baloncesto);
        $manager->persist($section4);

        $karate = new Event();
        $karate->setTitle('Karate');
        $karate->setDescription('Defensa personal y combate');
        $karate->setImage("https://olympics.com/images/static/sports/pictograms/v2/kte.svg");
        $karate->setDate(new \DateTime('2024-06-28 17:00:00'));
        $manager->persist($karate);

        $section1 = new Section();
        $section1->setDescription('Sección 1');
        $section1->setSlots(100);
        $section1->setPrice(80);
        $section1->setEvent($karate);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setDescription('Sección 2');
        $section2->setSlots(100);
        $section2->setPrice(70);
        $section2->setEvent($karate);
        $manager->persist($section2);

        $section3 = new Section();
        $section3->setDescription('Sección 3');
        $section3->setSlots(100);
        $section3->setPrice(60);
        $section3->setEvent($karate);
        $manager->persist($section3);

        $section4 = new Section();
        $section4->setDescription('Sección 4');
        $section4->setSlots(100);
        $section4->setPrice(50);
        $section4->setEvent($karate);
        $manager->persist($section4);

        $natacion = new Event();
        $natacion->setTitle('Natación');
        $natacion->setDescription('Rapidez en el agua');
        $natacion->setImage("https://olympics.com/images/static/sports/pictograms/v2/swm.svg");
        $natacion->setDate(new \DateTime('2024-07-01 19:00:00'));
        $manager->persist($natacion);

        $section1 = new Section();
        $section1->setDescription('Sección 1');
        $section1->setSlots(100);
        $section1->setPrice(50);
        $section1->setEvent($natacion);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setDescription('Sección 2');
        $section2->setSlots(100);
        $section2->setPrice(40);
        $section2->setEvent($natacion);
        $manager->persist($section2);

        $section3 = new Section();
        $section3->setDescription('Sección 3');
        $section3->setSlots(100);
        $section3->setPrice(30);
        $section3->setEvent($natacion);
        $manager->persist($section3);

        $section4 = new Section();
        $section4->setDescription('Sección 4');
        $section4->setSlots(100);
        $section4->setPrice(20);
        $section4->setEvent($natacion);
        $manager->persist($section4);

        $futbol = new Event();
        $futbol->setTitle('Fútbol');
        $futbol->setDescription('Técnica y táctica');
        $futbol->setImage("https://olympics.com/images/static/sports/pictograms/v2/fbl.svg");
        $futbol->setDate(new \DateTime('2024-07-15 20:00:00'));
        $manager->persist($futbol);

        $section1 = new Section();
        $section1->setDescription('Sección 1');
        $section1->setSlots(100);
        $section1->setPrice(200);
        $section1->setEvent($futbol);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setDescription('Sección 2');
        $section2->setSlots(100);
        $section2->setPrice(180);
        $section2->setEvent($futbol);
        $manager->persist($section2);

        $section3 = new Section();
        $section3->setDescription('Sección 3');
        $section3->setSlots(100);
        $section3->setPrice(160);
        $section3->setEvent($futbol);
        $manager->persist($section3);

        $section4 = new Section();
        $section4->setDescription('Sección 4');
        $section4->setSlots(100);
        $section4->setPrice(140);
        $section4->setEvent($futbol);
        $manager->persist($section4);

        $manager->flush();
    }
}
