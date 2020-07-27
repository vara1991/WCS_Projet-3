<?php

namespace App\Entity;

use App\Repository\EvalYnRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvalYnRepository::class)
 */
class EvalYn
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
    private $response;

    /**
     * @ORM\OneToMany(targetEntity=ResponseYn::class, mappedBy="eval_yn", orphanRemoval=true)
     */
    private $responseYns;

    public function __construct()
    {
        $this->responseYns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(string $response): self
    {
        $this->response = $response;

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
            $responseYn->setEvalYn($this);
        }

        return $this;
    }

    public function removeResponseYn(ResponseYn $responseYn): self
    {
        if ($this->responseYns->contains($responseYn)) {
            $this->responseYns->removeElement($responseYn);
            // set the owning side to null (unless already changed)
            if ($responseYn->getEvalYn() === $this) {
                $responseYn->setEvalYn(null);
            }
        }

        return $this;
    }
}
