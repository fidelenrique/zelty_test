<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends CommonController
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    #[Route('/api/articles/{id<\d+>}', name: 'api_articles_get_one', methods: ['GET'])]
    public function getArticle(int $id, LoggerInterface $logger): Response
    {
        $repoArticle = $this->em->getRepository(Article::class);
        /** @var Article $article */
        $article = $repoArticle->findArticles('');

        $article = [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'content' => $article->getContent(),

        ];

        $logger->info('Returning API response for article {article}', [
            'article' => $id,
        ]);

        return $this->json($article);
    }
}
