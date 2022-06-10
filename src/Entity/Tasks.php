<?php

namespace App\Entity;

use App\Repository\TasksRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: TasksRepository::class)]
class Tasks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    #[Assert\Length(min: 2,max:150,minMessage:"Le nom saisi est trop court", maxMessage:"Le nom saisi est trop long")]
    #[Assert\NotBlank(message:"Veuillez renseigner le nom de la tâche")]
    private $title;

    #[ORM\Column(type: 'boolean')]
    private $done;

    #[ORM\ManyToOne(targetEntity: Todoslists::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private $list;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }

    public function getList(): ?Todoslists
    {
        return $this->list;
    }

    public function setList(?Todoslists $list): self
    {
        $this->list = $list;

        return $this;
    }
}
