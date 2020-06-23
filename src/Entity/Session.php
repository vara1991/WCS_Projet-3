<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_archived;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $connection_number;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="sessions")
     */
    private $company;

    /**
     * @ORM\OneToOne(targetEntity=Training::class, mappedBy="session", cascade={"persist", "remove"})
     */
    private $training;

    /**
     * @ORM\OneToMany(targetEntity=Certificate::class, mappedBy="session")
     */
    private $certificates;

    /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="session")
     */
    private $participants;

    public function __construct()
    {
        $password = substr(str_shuffle('0123456789'),0,4);
        $this->certificates = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->setPassword($password);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsArchived(): ?bool
    {
        return $this->is_archived;
    }

    public function setIsArchived(bool $is_archived): self
    {
        $this->is_archived = $is_archived;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getConnectionNumber(): ?int
    {
        return $this->connection_number;
    }

    public function setConnectionNumber(int $connection_number): self
    {
        $this->connection_number = $connection_number;

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

        // set (or unset) the owning side of the relation if necessary
        $newSession = null === $training ? null : $this;
        if ($training->getSession() !== $newSession) {
            $training->setSession($newSession);
        }

        return $this;
    }

    /**
     * @return Collection|Certificate[]
     */
    public function getCertificates(): Collection
    {
        return $this->certificates;
    }

    public function addCertificate(Certificate $certificate): self
    {
        if (!$this->certificates->contains($certificate)) {
            $this->certificates[] = $certificate;
            $certificate->setSession($this);
        }

        return $this;
    }

    public function removeCertificate(Certificate $certificate): self
    {
        if ($this->certificates->contains($certificate)) {
            $this->certificates->removeElement($certificate);
            // set the owning side to null (unless already changed)
            if ($certificate->getSession() === $this) {
                $certificate->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setSession($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
            // set the owning side to null (unless already changed)
            if ($participant->getSession() === $this) {
                $participant->setSession(null);
            }
        }

        return $this;
    }

    public function __toString() {

        return $this->getCompany()->getName();
    }
}
