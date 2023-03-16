<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeInterface;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    const DRAFT = "brouillon";
    const PUBLISHED = "publié";
    const DELETED = "supprimé";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?object $author = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $status = null;

    /**
     * @var DateTimeInterface A "Y-m-d H:i:s" formatted value
     */
    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected DateTimeInterface $publishedAt;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return object|null
     */
    public function getAuthor(): ?object
    {
        return $this->author;
    }

    /**
     * @param object|null $author
     */
    public function setAuthor(?object $author): void
    {
        $this->author = $author;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublishedAt(): string
    {
        return $this->publishedAt;
    }

    /**
     * @param DateTimeInterface $publishedAt
     * @return $this
     */
    public function setPublishedAt(DateTimeInterface $publishedAt): Article
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
