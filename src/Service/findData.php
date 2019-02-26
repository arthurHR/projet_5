<?php

namespace App\Service;

use App\Repository\SkillsRepository;
use App\Repository\ProjectsRepository;
use App\Repository\AboutRepository;


class findData
{
    public $data;

    public function __construct(SkillsRepository $repoSkills, ProjectsRepository $repoProjects, AboutRepository $repoAbout )
    {
        $skills = $repoSkills->findAll();
        $projects = $repoProjects->findAll();
        $about = $repoAbout->findAll();
        $this->data = array(
            "skills" => $skills,
            "projects" => $projects,
            "about" => $about,
        );
    }
}