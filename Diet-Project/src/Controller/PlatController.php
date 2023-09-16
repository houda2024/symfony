<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Plat;
use App\Form\PlatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class PlatController extends AbstractController
{
    /**
     * @Route("/plat", name="app_plat")
     */
    public function index(): Response
    {
        return $this->render('plat/index.html.twig', [
            'controller_name' => 'PlatController',
        ]);
    }

    /**
 * @Route("/plats/Ajouter", name="plat_ajouter")
 */
public function Ajouter(Request $request, EntityManagerInterface $entityManager)
{
    $plat = new Plat();
    $form = $this->createForm(PlatType::class, $plat);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($plat);
        $entityManager->flush();

        return $this->redirectToRoute('plat_index');
    }

    return $this->render('plat/ajouter.html.twig', [
        'form' => $form->createView(),
    ]);
}

    /**
 * @Route("/plats/show", name="plat_show")
 */
public function show(Request $request, EntityManagerInterface $entityManager)
{
    $id = $request->query->get('id');
    $plat = $entityManager->getRepository(Plat::class)->find($id);

    if (!$plat) {
        throw $this->createNotFoundException('Le plat n\'a pas été trouvé');
    }

    return $this->render('plat/show.html.twig', [
        'plat' => $plat,
    ]);
}


}
