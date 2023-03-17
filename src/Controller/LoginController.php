<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityRepository;

class LoginController extends CommonController
{
    private EntityRepository $repoUser;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
        $this->repoUser = $this->em->getRepository(User::class);
    }

    #[Route('/login', name: 'app_login', methods: ['GET'])]
    public function index(): Response
    {
        $content = json_decode($this->apiHello('enrique')->getContent());

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'content' => $content,
        ]);
    }

    #[Route('/api/hello/{name}', methods: ['GET'])]
    public function apiHello(string $name): JsonResponse
    {
        return $this->json([
            'name' => $name,
            'symfony' => 'rocks',
        ]);
    }
}
