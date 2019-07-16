<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Student", mappedBy="skills")
     */
    private $students;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Student", mappedBy="skillsToLearn")
     */
    private $interestedStudents;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->interestedStudents = new ArrayCollection();
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

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addSkill($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->removeSkill($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection|Student[]
     */
    public function getInterestedStudents(): Collection
    {
        return $this->interestedStudents;
    }

    public function addInterestedStudent(Student $interestedStudent): self
    {
        if (!$this->interestedStudents->contains($interestedStudent)) {
            $this->interestedStudents[] = $interestedStudent;
            $interestedStudent->addSkillsToLearn($this);
        }

        return $this;
    }

    public function removeInterestedStudent(Student $interestedStudent): self
    {
        if ($this->interestedStudents->contains($interestedStudent)) {
            $this->interestedStudents->removeElement($interestedStudent);
            $interestedStudent->removeSkillsToLearn($this);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
