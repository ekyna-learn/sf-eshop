<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 * @package ShopBundle\Controller
 */
class PageController extends Controller
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('ShopBundle:Page:index.html.twig');
    }

    /**
     * Contact action.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        $data = [
            'email'      => null,
            'subject'    => null,
            'service'    => null,
            'message'    => null,
            'attachment' => null,
        ];

        /** @var \Symfony\Component\Form\FormInterface $form */
        $form = $this
            ->createFormBuilder($data)
            ->add('email', 'email', [
                'label' => 'Votre adresse email',
            ])
            ->add('subject', 'text', [
                'label' => 'Sujet de votre message',
            ])
            ->add('service', 'choice', [
                'label'             => 'Service concerné',
                'choices'           => [
                    'Service commercial'  => 1,
                    'Service facturation' => 2,
                    'Service technique'   => 3,
                ],
                'choices_as_values' => true,
                'placeholder'       => 'Choisissez un service',
            ])
            ->add('message', 'textarea', [
                'label' => 'Votre message',
                'attr'  => [
                    'rows' => 8,
                ],
            ])
            ->add('attachment', 'file', [
                'label'    => 'Pièce jointe',
                'required' => false,
            ])
            ->add('send', 'submit', [
                'label' => 'Envoyer',
                'attr'  => [
                    'class' => 'btn btn-primary',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // TODO Use the mailer service.

            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('shop_contact');
        }

        return $this->render('ShopBundle:Page:contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
