<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="participants")
     */
    private $company;

    /**
     * @ORM\OneToOne(targetEntity=Certificate::class, mappedBy="participant", cascade={"persist", "remove"})
     */
    private $certificate;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\OneToOne(targetEntity=Evaluation::class, cascade={"persist", "remove"})
     */
    private $evaluation;

    /**
     * @ORM\ManyToOne(targetEntity=Civility::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $civility;

    /**
     * @ORM\OneToMany(targetEntity=ResponseQcm::class, mappedBy="participant", orphanRemoval=true)
     */
    private $responseQcms;

    public function __construct()
    {
        $this->responseQcms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getCertificate(): ?Certificate
    {
        return $this->certificate;
    }

    public function setCertificate(Certificate $certificate): self
    {
        $this->certificate = $certificate;

        // set the owning side of the relation if necessary
        if ($certificate->getParticipant() !== $this) {
            $certificate->setParticipant($this);
        }

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

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getCivility(): ?Civility
    {
        return $this->civility;
    }

    public function setCivility(?Civility $civility): self
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * @return Collection|ResponseQcm[]
     */
    public function getResponseQcms(): Collection
    {
        return $this->responseQcms;
    }

    public function addResponseQcm(ResponseQcm $responseQcm): self
    {
        if (!$this->responseQcms->contains($responseQcm)) {
            $this->responseQcms[] = $responseQcm;
            $responseQcm->setParticipant($this);
        }

        return $this;
    }

    public function removeResponseQcm(ResponseQcm $responseQcm): self
    {
        if ($this->responseQcms->contains($responseQcm)) {
            $this->responseQcms->removeElement($responseQcm);
            // set the owning side to null (unless already changed)
            if ($responseQcm->getParticipant() === $this) {
                $responseQcm->setParticipant(null);
            }
        }

        return $this;

    public function __toString() {

        return $this->getLastname();

    }
}
