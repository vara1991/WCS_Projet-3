<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $global_score;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=Training::class, inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $training;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="evaluations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=ResponseYn::class, mappedBy="evaluation", orphanRemoval=true)
     */
    private $responseYns;

    /**
     * @ORM\OneToMany(targetEntity=ResponseScore::class, mappedBy="evaluation", orphanRemoval=true)
     */
    private $responseScores;

    public function __construct()
    {
        $this->responseYns = new ArrayCollection();
        $this->responseScores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getGlobalScore(): ?int
    {
        return $this->global_score;
    }

    public function setGlobalScore(int $global_score): self
    {
        $this->global_score = $global_score;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|ResponseYn[]
     */
    public function getResponseYns(): Collection
    {
        return $this->responseYns;
    }

    public function addResponseYn(ResponseYn $responseYn): self
    {
        if (!$this->responseYns->contains($responseYn)) {
            $this->responseYns[] = $responseYn;
            $responseYn->setEvaluation($this);
        }

        return $this;
    }

    public function removeResponseYn(ResponseYn $responseYn): self
    {
        if ($this->responseYns->contains($responseYn)) {
            $this->responseYns->removeElement($responseYn);
            // set the owning side to null (unless already changed)
            if ($responseYn->getEvaluation() === $this) {
                $responseYn->setEvaluation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ResponseScore[]
     */
    public function getResponseScores(): Collection
    {
        return $this->responseScores;
    }

    public function addResponseScore(ResponseScore $responseScore): self
    {
        if (!$this->responseScores->contains($responseScore)) {
            $this->responseScores[] = $responseScore;
            $responseScore->setEvaluation($this);
        }

        return $this;
    }

    public function removeResponseScore(ResponseScore $responseScore): self
    {
        if ($this->responseScores->contains($responseScore)) {
            $this->responseScores->removeElement($responseScore);
            // set the owning side to null (unless already changed)
            if ($responseScore->getEvaluation() === $this) {
                $responseScore->setEvaluation(null);
            }
        }

        return $this;
    }
}
