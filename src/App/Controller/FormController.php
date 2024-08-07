<?php

namespace App\Controller;

use App\Form\FormType;
use App\Service\FormCalcService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    private FormCalcService $service;

    public function __construct(FormCalcService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/form", name="app_form", methods={"GET"})
     */
    public function show(): Response
    {
        $form = $this->createForm(FormType::class, null, [
            'action' => $this->generateUrl('app_form_result'),
            'method' => 'POST',
        ]);

        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/form", name="app_form_result", methods={"POST"})
     * @throws \Exception
     */
    public function result(Request $request): Response
    {
        $form = $this->createForm(FormType::class);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->render('form/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $formResult = $this->service->calcResult($form->getData());

        return $this->render('form/index.html.twig', [
            'form' => $form->createView(),
            'formResult' => $formResult,
        ]);
    }
}
