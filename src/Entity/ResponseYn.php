<?php

namespace App\Entity;

use App\Repository\ResponseYnRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseYnRepository::class)
 */
class ResponseYn
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluation::class, inversedBy="responseYns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation;

    /**
     * @ORM\ManyToOne(targetEntity=EvalYn::class, inversedBy="responseYns")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eval_yn;

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

    public function getEvalYn(): ?EvalYn
    {
        return $this->eval_yn;
    }

    public function setEvalYn(?EvalYn $eval_yn): self
    {
        $this->eval_yn = $eval_yn;

        return $this;
    }
}
