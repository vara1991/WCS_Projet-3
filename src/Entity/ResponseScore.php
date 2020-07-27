<?php

namespace App\Entity;

use App\Repository\ResponseScoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseScoreRepository::class)
 */
class ResponseScore
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluation::class, inversedBy="responseScores")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation;

    /**
     * @ORM\ManyToOne(targetEntity=EvalScore::class, inversedBy="responseScores")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eval_score;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEvalScore(): ?EvalScore
    {
        return $this->eval_score;
    }

    public function setEvalScore(?EvalScore $eval_score): self
    {
        $this->eval_score = $eval_score;

        return $this;
    }
}
