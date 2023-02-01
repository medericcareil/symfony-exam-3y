<?php

namespace App\DataFixtures;

use App\Entity\VideoType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VideoTypeFixtures extends Fixture
{
    public const FILM = 'Films';
    public const SERIE = 'Séries';

    public function load(ObjectManager $manager): void
    {
        $videoTypeFilms = (new VideoType())
            ->setName('Films')
        ;
        $manager->persist($videoTypeFilms);
        
        $videoTypeSeries = (new VideoType())
            ->setName('Séries')
        ;
        $manager->persist($videoTypeSeries);

        $manager->flush();

        $this->addReference(self::FILM, $videoTypeFilms);
        $this->addReference(self::SERIE, $videoTypeSeries);
    }
}
