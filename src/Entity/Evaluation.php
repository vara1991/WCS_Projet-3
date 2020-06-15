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
     * @ORM\ManyToMany(targetEntity=EvalYn::class, inversedBy="evaluations")
     */
    private $evaluations;

    /**
     * @ORM\ManyToMany(targetEntity=EvalScore::class, inversedBy="evaluations")
     */
    private $eval_score;

    public function __construct()
    {
        $this->eval_score = new ArrayCollection();
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
     * @return Collection|EvalYn[]
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(EvalYn $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
        }

        return $this;
    }

    public function removeEvaluation(EvalYn $evaluation): self
    {
        if ($this->evaluations->contains($evaluation)) {
            $this->evaluations->removeElement($evaluation);
        }

        return $this;
    }

    /**
     * @return Collection|EvalScore[]
     */
    public function getEvalScore(): Collection
    {
        return $this->eval_score;
    }

    public function addEvalScore(EvalScore $evalScore): self
    {
        if (!$this->eval_score->contains($evalScore)) {
            $this->eval_score[] = $evalScore;
        }

        return $this;
    }

    public function removeEvalScore(EvalScore $evalScore): self
    {
        if ($this->eval_score->contains($evalScore)) {
            $this->eval_score->removeElement($evalScore);
        }

        return $this;
    }
}
