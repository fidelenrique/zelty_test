<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\InfoCodes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Exception;

/**
 * @codeCoverageIgnore
 */
class CommonController extends AbstractController
{
    protected EntityManagerInterface $em;

    /**
     * CommonController constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    protected function getJsonContent($message): array
    {
        $data = [];
        if (is_array($message)) {
            $data['messages'] = (object) $message;
        } else {
            $data['messages'] = ['info' => [$message]];
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    protected function getLoggedUser(): UserInterface
    {
        $user = $this->getUser();
        if (!$user instanceof UserInterface) {
            throw new Exception(InfoCodes::USR_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        return $user;
    }

    /**
     * @throws Exception
     */
    protected function getArticleById($id): Article
    {
        $repoArticle = $this->em->getRepository(Article::class);
        $article = $repoArticle->findOneBy(['id' => $id, 'status' => Article::DRAFT])?? $repoArticle->findOneBy(['id' => $id, 'status' => Article::PUBLISHED]);

        if (!$article instanceof Article) {
            throw new Exception(InfoCodes::ART_NOT_FOUND, Response::HTTP_BAD_REQUEST);
        }

        return $article;
    }
}