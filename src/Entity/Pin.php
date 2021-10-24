<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PinRepository;
use App\Entity\Traits\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PinRepository::class)
 * @ORM\Table(name="pins")
 *  @ORM\HasLifecycleCallbacks
 */
class Pin
{
    /**
     * pour l'utiliser a ne pas oublier l'anotation @ORM\HasLifecycleCallbacks
     */
    use Timestampable;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le titre ne peut pas Etre vide")
     * @Assert\Length(min=3)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="la description ne peut pas Etre vide")
     * @Assert\Length(min=10,minMessage="ajouter plus de contenue a la description")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ImageName;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->ImageName;
    }

    public function setImageName(?string $ImageName): self
    {
        $this->ImageName = $ImageName;

        return $this;
    }

    
}
