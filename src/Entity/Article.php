<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Article
{
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="articles")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private User $user;
}
