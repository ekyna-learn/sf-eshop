<?php

namespace ShopBundle\Controller\Admin;

use ShopBundle\Entity\Feature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Feature controller.
 *
 */
class FeatureController extends Controller
{
    /**
     * Lists all feature entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $features = $em->getRepository('ShopBundle:Feature')->findAll();

        return $this->render('ShopBundle:Admin/Feature:index.html.twig', array(
            'features' => $features,
        ));
    }

    /**
     * Creates a new feature entity.
     *
     */
    public function newAction(Request $request)
    {
        $feature = new Feature();
        $form = $this
                ->createForm('ShopBundle\Form\FeatureType', $feature)
                ->add('save', new SubmitType(), [
                    'attr' => [
                        'class' => 'btn btn-sm btn-success',
                    ]
                ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feature);
            $em->flush($feature);

            return $this->redirectToRoute('shop_admin_feature_show', array('id' => $feature->getId()));
        }

        return $this->render('ShopBundle:Admin/Feature:new.html.twig', array(
            'feature' => $feature,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a feature entity.
     *
     */
    public function showAction(Feature $feature)
    {
        $deleteForm = $this->createDeleteForm($feature);

        return $this->render('ShopBundle:Admin/Feature:show.html.twig', array(
            'feature' => $feature,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing feature entity.
     *
     */
    public function editAction(Request $request, Feature $feature)
    {
        $deleteForm = $this->createDeleteForm($feature);
        $editForm = $this
                ->createForm('ShopBundle\Form\FeatureType', $feature)
                ->add('save', new SubmitType(), [
                    'attr' => [
                        'class' => 'btn btn-sm btn-primary',
                    ]
                ]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shop_admin_feature_edit', array('id' => $feature->getId()));
        }

        return $this->render('ShopBundle:Admin/Feature:edit.html.twig', array(
            'feature' => $feature,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a feature entity.
     *
     */
    public function deleteAction(Request $request, Feature $feature)
    {
        $form = $this->createDeleteForm($feature);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($feature);
            $em->flush();
        }

        return $this->redirectToRoute('shop_admin_feature_index');
    }

    /**
     * Creates a form to delete a feature entity.
     *
     * @param Feature $feature The feature entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Feature $feature)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shop_admin_feature_delete', array('id' => $feature->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
