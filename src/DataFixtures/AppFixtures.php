<?php

namespace App\DataFixtures;

use App\Entity\Event;
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
        $atletismo1 = new Event();
        $atletismo1->setTitle('Atletismo sector 4');
        $atletismo1->setDescription('Salto y velocidad');
        $atletismo1->setPrice(150);
        $atletismo1->setSlots(100);
        $atletismo1->setImage("https://olympics.com/images/static/sports/pictograms/v2/ath.svg");
        $atletismo1->setDate(new \DateTime('2024-06-01 18:00:00'));
        $manager->persist($atletismo1);

        $atletismo2 = new Event();
        $atletismo2->setTitle('Atletismo sector 4');
        $atletismo2->setDescription('Salto y velocidad');
        $atletismo2->setPrice(110);
        $atletismo2->setSlots(100);
        $atletismo2->setImage("https://olympics.com/images/static/sports/pictograms/v2/ath.svg");
        $atletismo2->setDate(new \DateTime('2024-06-01 18:00:00'));
        $manager->persist($atletismo2);

        $atletismo3 = new Event();
        $atletismo3->setTitle('Atletismo sector 4');
        $atletismo3->setDescription('Salto y velocidad');
        $atletismo3->setPrice(90);
        $atletismo3->setSlots(100);
        $atletismo3->setImage("https://olympics.com/images/static/sports/pictograms/v2/ath.svg");
        $atletismo3->setDate(new \DateTime('2024-06-01 18:00:00'));
        $manager->persist($atletismo3);

        $atletismo4 = new Event();
        $atletismo4->setTitle('Atletismo sector 4');
        $atletismo4->setDescription('Salto y velocidad');
        $atletismo4->setPrice(70);
        $atletismo4->setSlots(100);
        $atletismo4->setImage("https://olympics.com/images/static/sports/pictograms/v2/ath.svg");
        $atletismo4->setDate(new \DateTime('2024-06-01 18:00:00'));
        $manager->persist($atletismo4);
        
        $baloncesto1 = new Event();
        $baloncesto1->setTitle('Baloncesto sector 1');
        $baloncesto1->setDescription('Estrategia y dribbling');
        $baloncesto1->setPrice(100);
        $baloncesto1->setSlots(100);
        $baloncesto1->setImage("https://olympics.com/images/static/sports/pictograms/v2/bkb.svg");
        $baloncesto1->setDate(new \DateTime('2024-06-15 16:00:00'));
        $manager->persist($baloncesto1);

        $baloncesto2 = new Event();
        $baloncesto2->setTitle('Baloncesto sector 2');
        $baloncesto2->setDescription('Estrategia y dribbling');
        $baloncesto2->setPrice(80);
        $baloncesto2->setSlots(100);
        $baloncesto2->setImage("https://olympics.com/images/static/sports/pictograms/v2/bkb.svg");
        $baloncesto2->setDate(new \DateTime('2024-06-15 16:00:00'));
        $manager->persist($baloncesto2);       

        $baloncesto3 = new Event();
        $baloncesto3->setTitle('Baloncesto sector 3');
        $baloncesto3->setDescription('Estrategia y dribbling');
        $baloncesto3->setPrice(60);
        $baloncesto3->setSlots(100);
        $baloncesto3->setImage("https://olympics.com/images/static/sports/pictograms/v2/bkb.svg");
        $baloncesto3->setDate(new \DateTime('2024-06-15 16:00:00'));
        $manager->persist($baloncesto3); 

        $baloncesto4 = new Event();
        $baloncesto4->setTitle('Baloncesto sector 4');
        $baloncesto4->setDescription('Estrategia y dribbling');
        $baloncesto4->setPrice(50);
        $baloncesto4->setSlots(100);
        $baloncesto4->setImage("https://olympics.com/images/static/sports/pictograms/v2/bkb.svg");
        $baloncesto4->setDate(new \DateTime('2024-06-15 16:00:00'));
        $manager->persist($baloncesto4); 

        $karate1 = new Event();
        $karate1->setTitle('Karate sector 1');
        $karate1->setDescription('Defensa personal y combate');
        $karate1->setPrice(60);
        $karate1->setSlots(100);
        $karate1->setImage("https://olympics.com/images/static/sports/pictograms/v2/kte.svg");
        $karate1->setDate(new \DateTime('2024-06-28 17:00:00'));
        $manager->persist($karate1);

        $karate2 = new Event();
        $karate2->setTitle('Karate sector 2');
        $karate2->setDescription('Defensa personal y combate');
        $karate2->setPrice(50);
        $karate2->setSlots(100);
        $karate2->setImage("https://olympics.com/images/static/sports/pictograms/v2/kte.svg");
        $karate2->setDate(new \DateTime('2024-06-28 17:00:00'));
        $manager->persist($karate2);

        $karate3 = new Event();
        $karate3->setTitle('Karate sector 3');
        $karate3->setDescription('Defensa personal y combate');
        $karate3->setPrice(40);
        $karate3->setSlots(100);
        $karate3->setImage("https://olympics.com/images/static/sports/pictograms/v2/kte.svg");
        $karate3->setDate(new \DateTime('2024-06-28 17:00:00'));
        $manager->persist($karate3);

        $karate4 = new Event();
        $karate4->setTitle('Karate sector 4');
        $karate4->setDescription('Defensa personal y combate');
        $karate4->setPrice(30);
        $karate4->setSlots(100);
        $karate4->setImage("https://olympics.com/images/static/sports/pictograms/v2/kte.svg");
        $karate4->setDate(new \DateTime('2024-06-28 17:00:00'));
        $manager->persist($karate4);

        $natacion1 = new Event();
        $natacion1->setTitle('Natación sector 1');
        $natacion1->setDescription('Rapidez en el agua');
        $natacion1->setPrice(50);
        $natacion1->setSlots(100);
        $natacion1->setImage("https://olympics.com/images/static/sports/pictograms/v2/swm.svg");
        $natacion1->setDate(new \DateTime('2024-07-01 19:00:00'));
        $manager->persist($natacion1);

        $natacion2 = new Event();
        $natacion2->setTitle('Natación sector 2');
        $natacion2->setDescription('Rapidez en el agua');
        $natacion2->setPrice(30);
        $natacion2->setSlots(100);
        $natacion2->setImage("https://olympics.com/images/static/sports/pictograms/v2/swm.svg");
        $natacion2->setDate(new \DateTime('2024-07-01 19:00:00'));
        $manager->persist($natacion2);

        $natacion3 = new Event();
        $natacion3->setTitle('Natación sector 3');
        $natacion3->setDescription('Rapidez en el agua');
        $natacion3->setPrice(20);
        $natacion3->setSlots(100);
        $natacion3->setImage("https://olympics.com/images/static/sports/pictograms/v2/swm.svg");
        $natacion3->setDate(new \DateTime('2024-07-01 19:00:00'));
        $manager->persist($natacion3);

        $natacion4 = new Event();
        $natacion4->setTitle('Natación sector 4');
        $natacion4->setDescription('Rapidez en el agua');
        $natacion4->setPrice(10);
        $natacion4->setSlots(100);
        $natacion4->setImage("https://olympics.com/images/static/sports/pictograms/v2/swm.svg");
        $natacion4->setDate(new \DateTime('2024-07-01 19:00:00'));
        $manager->persist($natacion4);

        $futbol1 = new Event();
        $futbol1->setTitle('Fútbol sector 1');
        $futbol1->setDescription('Técnica y táctica');
        $futbol1->setPrice(200);
        $futbol1->setSlots(100);
        $futbol1->setImage("https://olympics.com/images/static/sports/pictograms/v2/fbl.svg");
        $futbol1->setDate(new \DateTime('2024-07-15 20:00:00'));
        $manager->persist($futbol1);

        $futbol2 = new Event();
        $futbol2->setTitle('Fútbol sector 2');
        $futbol2->setDescription('Técnica y táctica');
        $futbol2->setPrice(200);
        $futbol2->setSlots(100);
        $futbol2->setImage("https://olympics.com/images/static/sports/pictograms/v2/fbl.svg");
        $futbol2->setDate(new \DateTime('2024-07-15 20:00:00'));
        $manager->persist($futbol2);

        $futbol3 = new Event();
        $futbol3->setTitle('Fútbol sector 3');
        $futbol3->setDescription('Técnica y táctica');
        $futbol3->setPrice(200);
        $futbol3->setSlots(100);
        $futbol3->setImage("https://olympics.com/images/static/sports/pictograms/v2/fbl.svg");
        $futbol3->setDate(new \DateTime('2024-07-15 20:00:00'));
        $manager->persist($futbol3);

        $futbol4 = new Event();
        $futbol4->setTitle('Fútbol sector 4');
        $futbol4->setDescription('Técnica y táctica');
        $futbol4->setPrice(200);
        $futbol4->setSlots(100);
        $futbol4->setImage("https://olympics.com/images/static/sports/pictograms/v2/fbl.svg");
        $futbol4->setDate(new \DateTime('2024-07-15 20:00:00'));
        $manager->persist($futbol4);

        $manager->flush();
    }
}
