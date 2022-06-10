<?php

namespace App\Entity;

use App\Repository\TodoslistsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: TodoslistsRepository::class)]
#[ORM\Table(name:"lists")]

class Todoslists
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 80)]
    #[Assert\Length(min: 2,max:80,minMessage:"Le nom saisi est trop court", maxMessage:"Le nom saisi est trop long")]
    #[Assert\NotBlank(message:"Veuillez renseigner le nom de la liste")]
    
    private $name;

    #[ORM\Column(type: 'string', length: 15)]
    #[Assert\NotBlank(message:"Veuillez renseigner la couleur de la liste")]
    #[Assert\Length(min: 6,max:15,minMessage:"La couleur saisie est trop courte", maxMessage:"La couleur saisie est trop longue")]
    private $color;

    #[ORM\OneToMany(mappedBy: 'list', targetEntity: Tasks::class, orphanRemoval: true)]
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Tasks>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Tasks $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setList($this);
        }

        return $this;
    }

    public function removeTask(Tasks $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getList() === $this) {
                $task->setList(null);
            }
        }

        return $this;
    }
}
