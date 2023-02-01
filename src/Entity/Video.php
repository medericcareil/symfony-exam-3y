<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VideoRepository;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $years;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=VideoType::class, inversedBy="videos")
     */
    private $videoType;

    public function __construct() {
        $this->id = Uuid::v4();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getYears(): ?string
    {
        return $this->years;
    }

    public function setYears(?string $years): self
    {
        $this->years =$years;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     * @return Video 
     */
    public function setCreatedAt(): self
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable('now');
        }
        return $this;
    }

    public function getVideoType(): ?VideoType
    {
        return $this->videoType;
    }

    public function setVideoType(?VideoType $videoType): self
    {
        $this->videoType = $videoType;

        return $this;
    }

    public static function toArray(Video $video): array {
        return [
            'id' => $video->getId(),
            'title' => $video->getName(),
            'synopsis' => $video->getSynopsis(),
            'year' => $video->getYears(),
            'type' => $video->getVideoType()->getName(),
            'createdAt' => $video->getCreatedAt()
        ];
    }
}
