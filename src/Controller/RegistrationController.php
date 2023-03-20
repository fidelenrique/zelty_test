<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    const NO_REPLY_EMAIL = 'reply@gmail.com';
    const NAME_NO_REPLY_EMAIL = 'No Reply';
    const SUBJECT_EMAIL = 'Please Confirm your Email';
    const HTML_TEMPLATE_EMAIL = 'registration/confirmation_email.html.twig';


    private JWTService $jwt;

    public function __construct(JWTService $jwt, private MailerInterface $mailer)
    {
        $this->jwt = $jwt;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager, JWTService $jwt): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //
            $user->setRoles(['ROLE_ADMIN']);
            $user->setFirstName($form->get('firstName')->getData());
            $entityManager->persist($user);
            $entityManager->flush();

            // we generate the JWT of the user
            // we create the header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            // we create the payload
            $payload = [
              'user_id' => $user->getId()
            ];

            // we generate the token
            $token = $this->jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            // generate a signed url and email it to the user
            $templateEmail = (new TemplatedEmail())
                ->from(new Address(self::NO_REPLY_EMAIL, self::NAME_NO_REPLY_EMAIL))
                ->to($user->getEmail())
                ->subject(self::SUBJECT_EMAIL)

                // path of the Twig template to render
                ->htmlTemplate(self::HTML_TEMPLATE_EMAIL)

                // pass variables (name => value) to the template
                ->context([
                    'expiration_date' => new \DateTime('+3 hours'),
                    'token' => $token,
                ])
            ;

            $this->mailer->send($templateEmail);

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UserRepository $usersRepository, EntityManagerInterface $em): Response
    {
        //On vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))){
            // On récupère le payload
            $payload = $jwt->getPayload($token);

            // On récupère le user du token
            $user = $usersRepository->find($payload['user_id']);

            //On vérifie que l'utilisateur existe et n'a pas encore activé son compte
            if($user && !$user->isVerified()){
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash('success', 'Utilisateur activé');
                return $this->redirectToRoute('app_login');
            }
        }
        // Ici un problème se pose dans le token
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }
}
