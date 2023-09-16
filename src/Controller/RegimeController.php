<?php

namespace App\Controller;
use App\Entity\Plat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfont\component\Validator\Constraints\DateTime;
use App\Entity\Regime;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RegimeRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\RegimeType;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;



class RegimeController extends AbstractController
{
    /**
 * @Route("/regimes", name="regime_index")
 */
public function index(RegimeRepository $repository)
{
    $regimes = $repository->findAll();

    return $this->render('regime/index.html.twig', [
        'regimes' => $regimes,
    ]);
}


    /**
 * @Route("/regime/editAll", name="regime_edit_all")
 */
public function editAll( Request $request, EntityManagerInterface $entityManager)
{
    $id = $request->query->get('id');
    $regime = $entityManager->getRepository(Regime::class)->find($id);

    if (!$regime) {
        throw $this->createNotFoundException('Le régime n\'a pas été trouvé');
    }

    $form = $this->createForm(RegimeType::class, $regime);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('regime_index');
    }

    return $this->render('regime/editAll.html.twig', [
        'form' => $form->createView(),
    ]);
}



     
    /**
 * @Route("/regimes", name="regime_home")
 */
public function home(RegimeRepository $regimeRepository)
{
    $regimes = $regimeRepository->findAll();

    return $this->render('regime/home.html.twig', [
        'regimes' => $regimes,
    ]);
}


    /**
 * @Route("/regimes/{id}/delete", name="regime_delete")
 */
public function delete(Regime $regime, EntityManagerInterface $entityManager)
{
    $entityManager->remove($regime);
    $entityManager->flush();

    return $this->redirectToRoute('regime_index');
}



    /**
 * @Route("/regimes/{id}/add", name="regime_add")
 */
public function add(Regime $regime, Request $request, EntityManagerInterface $entityManager)
{
    $plat = new Plat();
    $form = $this->createForm(PlatType::class, $plat);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $regime->addPlat($plat);
        $entityManager->flush();

        return $this->redirectToRoute('regime_index');
    }

    return $this->render('regime/add.html.twig', [
        'form' => $form->createView(),
    ]);
}
}


