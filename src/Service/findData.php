<?php

namespace App\Service;

use App\Repository\SkillsRepository;


class findData
{
    public $data;

    public function __construct(SkillsRepository $repo)
    {
        $skills = $repo->findAll();
        $this->data = array(
            "tilte" => "bienvenu",
            "skills" => $skills,
        );
    }
}