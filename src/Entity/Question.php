<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

// Pour pouvoir valider nos données
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez remplir ce champs")
     * @Assert\Length (min=10, max=255, minMessage="Votre question est trop courte", maxMessage="Votre question est trop longue")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreaed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
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

    public function getDateCreaed(): ?\DateTimeInterface
    {
        return $this->dateCreaed;
    }

    public function setDateCreaed(\DateTimeInterface $dateCreaed): self
    {
        $this->dateCreaed = $dateCreaed;

        return $this;
    }
}
