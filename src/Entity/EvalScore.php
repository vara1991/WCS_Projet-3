<?php

namespace App\Entity;

use App\Repository\EvalScoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvalScoreRepository::class)
 */
class EvalScore
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\OneToMany(targetEntity=ResponseScore::class, mappedBy="eval_score", orphanRemoval=true)
     */
    private $responseScores;

    public function __construct()
    {
        $this->responseScores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

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
            $responseScore->setEvalScore($this);
        }

        return $this;
    }

    public function removeResponseScore(ResponseScore $responseScore): self
    {
        if ($this->responseScores->contains($responseScore)) {
            $this->responseScores->removeElement($responseScore);
            // set the owning side to null (unless already changed)
            if ($responseScore->getEvalScore() === $this) {
                $responseScore->setEvalScore(null);
            }
        }

        return $this;
    }
}
