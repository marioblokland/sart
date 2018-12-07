<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="text", length=100)
     */
    private $title;
    
    /**
     * @ORM\Column(type="text")
     */
    private $body;
    
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    
    public function getBody(): ?string
    {
        return $this->body;
    }
    
    
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    
    
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
    
}
