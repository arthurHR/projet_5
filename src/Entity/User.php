<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */

    protected $first_name;

    /**
     * @ORM\Column(type="string")
     */

    protected $last_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $phone_number;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Skills", mappedBy="user")
     */
    private $skills;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\About", mappedBy="user")
     */
    private $abouts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Header", mappedBy="user")
     */
    private $headers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projects", mappedBy="user")
     */
    private $projects;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array('ROLE_USER');
        $this->skills = new ArrayCollection();
        $this->abouts = new ArrayCollection();
        $this->headers = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }


    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * @return Collection|Skills[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setUser($this);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            // set the owning side to null (unless already changed)
            if ($skill->getUser() === $this) {
                $skill->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|About[]
     */
    public function getAbouts(): Collection
    {
        return $this->abouts;
    }

    public function addAbout(About $about): self
    {
        if (!$this->abouts->contains($about)) {
            $this->abouts[] = $about;
            $about->setUser($this);
        }

        return $this;
    }

    public function removeAbout(About $about): self
    {
        if ($this->abouts->contains($about)) {
            $this->abouts->removeElement($about);
            // set the owning side to null (unless already changed)
            if ($about->getUser() === $this) {
                $about->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Header[]
     */
    public function getHeaders(): Collection
    {
        return $this->headers;
    }

    public function addHeader(Header $header): self
    {
        if (!$this->headers->contains($header)) {
            $this->headers[] = $header;
            $header->setUser($this);
        }

        return $this;
    }

    public function removeHeader(Header $header): self
    {
        if ($this->headers->contains($header)) {
            $this->headers->removeElement($header);
            // set the owning side to null (unless already changed)
            if ($header->getUser() === $this) {
                $header->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Projects[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Projects $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setUser($this);
        }

        return $this;
    }

    public function removeProject(Projects $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getUser() === $this) {
                $project->setUser(null);
            }
        }

        return $this;
    }
}