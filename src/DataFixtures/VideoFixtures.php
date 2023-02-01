<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var string
     */
    private string $projectRoot;

    public function __construct(string $projectRoot) {
        $this->projectRoot = $projectRoot;
    }

    public function getDependencies() {
        return [ VideoTypeFixtures::class ];
    }
    
    public function load(ObjectManager $manager): void
    {
        $json = file_get_contents(realpath($this->projectRoot . '/src/Data/film.json'), true);
        $content = json_decode($json, true);

        foreach ($content as $value) {
            $video = (new Video())
                ->setVideoType($value['Type'] === 'movie' ? $this->getReference(VideoTypeFixtures::FILM) : $this->getReference(VideoTypeFixtures::SERIE))
                ->setName($value['Title'])
                ->setSynopsis($value['Plot'])
                ->setYears($value['Year'])
            ;
            $manager->persist($video);
        }

        $manager->flush();
    }
}
