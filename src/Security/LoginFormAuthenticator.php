<?php

namespace App\Security;

use App\Repository\MembresRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    private UrlGeneratorInterface $urlGenerator;
    private UserPasswordHasherInterface $passwordHasher;
    private MembresRepository $userRepository;

    public function __construct(UrlGeneratorInterface $urlGenerator, UserPasswordHasherInterface $passwordHasher, MembresRepository $userRepository)
    {
        $this->urlGenerator = $urlGenerator;
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
    }

    // Méthode pour récupérer l'utilisateur et vérifier ses informations d'authentification
    public function authenticate(Request $request): Passport
    {
        // Vérifier si le honeypot est rempli avant de procéder à l'authentification
        if ($request->request->get('honeypot')) {
            // Si le honeypot est rempli, c'est probablement un bot
            throw new \Exception('Honeypot détecté, connexion invalide.');
        }

        $adressemail = $request->request->get('adressemail');
        $password = $request->request->get('password');

        // Récupérer l'utilisateur basé sur l'email
        $user = $this->userRepository->findOneBy(['adressemail' => $adressemail]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $adressemail);

        return new Passport(
            new UserBadge($adressemail),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    // Méthode exécutée lorsque l'authentification est un succès
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Si un chemin cible est défini, redirigez vers ce chemin, sinon vers la page d'accueil
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Rediriger vers la page utilisateur après une connexion réussie
        return new RedirectResponse($this->urlGenerator->generate('app_utilisateur'));
    }

    // Méthode pour récupérer l'URL de connexion
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate('app_login');
    }

    public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && $request->get('_route') === 'app_login';
    }
}
