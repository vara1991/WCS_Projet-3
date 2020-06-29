<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseRepository::class)
 */
class Response
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity=ResponseQcm::class, mappedBy="Response", orphanRemoval=true)
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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
            $responseQcm->setResponse($this);
        }

        return $this;
    }

    public function removeResponseQcm(ResponseQcm $responseQcm): self
    {
        if ($this->responseQcms->contains($responseQcm)) {
            $this->responseQcms->removeElement($responseQcm);
            // set the owning side to null (unless already changed)
            if ($responseQcm->getResponse() === $this) {
                $responseQcm->setResponse(null);
            }
        }

        return $this;
    }
}
