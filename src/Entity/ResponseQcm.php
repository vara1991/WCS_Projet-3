<?php

namespace App\Entity;

use App\Repository\ResponseQcmRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseQcmRepository::class)
 */
class ResponseQcm
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="responseQcms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $participant;

    /**
     * @ORM\ManyToOne(targetEntity=Response::class, inversedBy="responseQcms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Response;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->Response;
    }

    public function setResponse(?Response $Response): self
    {
        $this->Response = $Response;

        return $this;
    }
}
