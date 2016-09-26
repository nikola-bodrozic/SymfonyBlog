<?php

namespace Media\TravelBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Media\TravelBundle\Entity\Cinema;
use Media\TravelBundle\Form\CinemaType;

/**
 * Cinema controller.
 *
 */
class CinemaController extends Controller
{
    /**
     * Lists all Cinema entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cinemas = $em->getRepository('MediaTravelBundle:Cinema')->findAll();

        return $this->render('MediaTravelBundle:cinema:index.html.twig', array(
            'cinemas' => $cinemas,
        ));
    }

    /**
     * Creates a new Cinema entity.
     *
     */
    public function newAction(Request $request)
    {
        $cinema = new Cinema();
        $form = $this->createForm('Media\TravelBundle\Form\CinemaType', $cinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cinema);
            $em->flush();

            return $this->redirectToRoute('cinema_show', array('id' => $cinema->getId()));
        }

        return $this->render('MediaTravelBundle:cinema:new.html.twig', array(
            'cinema' => $cinema,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cinema entity.
     *
     */
    public function showAction(Cinema $cinema)
    {
        $deleteForm = $this->createDeleteForm($cinema);

        return $this->render('MediaTravelBundle:cinema:show.html.twig', array(
            'cinema' => $cinema,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cinema entity.
     *
     */
    public function editAction(Request $request, Cinema $cinema)
    {
        $deleteForm = $this->createDeleteForm($cinema);
        $editForm = $this->createForm('Media\TravelBundle\Form\CinemaType', $cinema);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cinema);
            $em->flush();

            return $this->redirectToRoute('cinema_edit', array('id' => $cinema->getId()));
        }

        return $this->render('MediaTravelBundle:cinema:edit.html.twig', array(
            'cinema' => $cinema,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Cinema entity.
     *
     */
    public function deleteAction(Request $request, Cinema $cinema)
    {
        $form = $this->createDeleteForm($cinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cinema);
            $em->flush();
        }

        return $this->redirectToRoute('cinema_index');
    }

    /**
     * Creates a form to delete a Cinema entity.
     *
     * @param Cinema $cinema The Cinema entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cinema $cinema)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cinema_delete', array('id' => $cinema->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
