<?php

namespace App\Entity;

use App\Repository\CertificateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CertificateRepository::class)
 */
class Certificate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $attestation;

    /**
     * @ORM\OneToOne(targetEntity=Participant::class, inversedBy="certificate", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $participant;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="certificates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="certificates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Training::class, inversedBy="certificates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $training;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttestation(): ?string
    {
        return $this->attestation;
    }

    public function setAttestation(string $attestation): self
    {
        $this->attestation = $attestation;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }
}
