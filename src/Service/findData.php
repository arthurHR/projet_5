<?php

namespace App\Service;

use App\Repository\SkillsRepository;
use App\Repository\ProjectsRepository;
use App\Repository\AboutRepository;
use App\Repository\HeaderRepository;



class findData
{
    public $data;

    public function __construct(SkillsRepository $repoSkills, ProjectsRepository $repoProjects, AboutRepository $repoAbout, HeaderRepository $repoHeader )
    {
        $header = $repoHeader->findAll();
        $about = $repoAbout->findAll();
        $skills = $repoSkills->findAll();
        $projects = $repoProjects->findAll();
        $this->data = array(
            "header" => $header,
            "about" => $about,
            "skills" => $skills,
            "projects" => $projects,
        );
    }
}