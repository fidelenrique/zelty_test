<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class StoreController extends CommonController
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    #[Route('/', name: 'app_homepage')]
    public function homepage(): Response
    {
        $repoArticle = $this->em->getRepository(Article::class);
        /** @var Article $article */
        $articles = $repoArticle->getArticles(Article::DELETED);

        return $this->render('store/homepage.html.twig', [
            'title' => 'Articles',
            'articles' => $articles,
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        return $this->render('store/browse.html.twig', [
            'genre' => $genre
        ]);
    }
}
