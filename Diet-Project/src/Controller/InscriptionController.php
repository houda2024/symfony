<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class InscriptionController extends AbstractController
{
    /**
 * @Route("/inscription", name="inscription")
 * @Security("not is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
public function inscription(Request $request)
{
    // Affichez le formulaire d'inscription
}

    /**
 * @Route("/inscription/check", name="inscription_check")
 * @Security("not is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
public function inscriptionCheck(Request $request, UserPasswordEncoderInterface $passwordEncoder)
{
    // Récupérez les données du formulaire d'inscription
    $username = $request->request->get('username');
    $password = $request->request->get('password');

    // Vérifiez si l'utilisateur existe déjà
    $existingUser = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy(['username' => $username]);

    if ($existingUser) {
        // Utilisateur existant, affichez un message d'erreur
        return $this->render('inscription/inscription.html.twig', [
            'error' => 'Utilisateur existant'
        ]);
    }

    // Créez un nouvel utilisateur
    $user = new User();
    $user->setUsername($username);
    $user->setPassword($passwordEncoder->encodePassword($user, $password));

    // Enregistrez l'utilisateur en base de données
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($user);
    $entityManager->flush();

    // Redirigez l'utilisateur vers la page de connexion
    return $this->redirectToRoute('security_login');
}
}