<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    /**
 * @Route("/security/show", name="security_show")
 */
public function show(Request $request)
{
    // Récupérez l'utilisateur connecté depuis la session
    $user = $request->getSession()->get('user');

    // Affichez les informations de l'utilisateur
    return $this->render('security/show.html.twig', [
        'user' => $user
    ]);
}


   /**
 * @Route("/security/register", name="security_register")
 */
public function register(Request $request)
{
    // Affichez le formulaire d'inscription
    return $this->render('security/register.html.twig');
}

/**
 * @Route("/security/register_check", name="security_register_check")
 */
public function registerCheck(Request $request, EntityManagerInterface $entityManager)
{
    // Récupérez les données du formulaire d'inscription
    $username = $request->request->get('username');
    $password = $request->request->get('password');

    // Créez un nouvel objet utilisateur
    $user = new User();
    $user->setUsername($username);
    $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

    // Enregistrez l'utilisateur en base de données
    $entityManager->persist($user);
    $entityManager->flush();

    // Authentifiez l'utilisateur et redirigez-le vers la page souhaitée
    $request->getSession()->set('user', $user);
    return $this->redirectToRoute('homepage');
}
/**
 * @Route("/security/login", name="security_login")
 */
public function login(Request $request)
{
    // Affichez le formulaire de connexion
    return $this->render('security/login.html.twig');
}






  

  /**
 * @Route("/security/login_check", name="security_login_check")
 */
public function loginCheck(Request $request)
{
    // Récupérez les données du formulaire de connexion
    $username = $request->request->get('username');
    $password = $request->request->get('password');

    // Vérifiez si l'utilisateur existe en base de données
    $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy(['username' => $username]);

    if (!$user) {
        // Utilisateur non trouvé, affichez un message d'erreur
        return $this->render('security/login.html.twig', [
            'error' => 'Utilisateur non trouvé'
        ]);
    }

    // Vérifiez si le mot de passe est correct
    if (!password_verify($password, $user->getPassword())) {
        // Mot de passe incorrect, affichez un message d'erreur
        return $this->render('security/login.html.twig', [
            'error' => 'Mot de passe incorrect'
        ]);
    }

    // Authentification réussie, stockez l'utilisateur dans la session et redirigez-le vers la page souhaitée
    $request->getSession()->set('user', $user);
    return $this->redirectToRoute('homepage');
}






    /**
 * @Route("/security/logout", name="security_logout")
 */
public function logout(Request $request)
{
    // Déconnectez l'utilisateur en supprimant son utilisateur de la session
    $request->getSession()->remove('user');

    // Redirigez l'utilisateur vers la page de connexion
    return $this->redirectToRoute('security_login');
}

}
