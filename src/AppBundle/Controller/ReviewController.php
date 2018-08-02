<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Review Controller
 *
 * @Route("review")
 */
class ReviewController extends Controller
{
    /**
     *  Lists all reviews entities.
     *
     * @Route("/", name="review_index", methods="GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reviews = $em->getRepository('AppBundle:Review')->findAll();

        return $this->render('review/index.html.twig', [
            'reviews' => $reviews
        ]);
    }

    /**
     * Creates a new review entity
     *
     * @Route("/new", name="review_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('review_show', ['id' => $review->getId()]);
        }

        return $this->render('review/new.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }

    /**
     *  Finds and displays a review entity.
     *
     * @Route("/{id}", name="review_show", methods="GET")
     */
    public function showAction(Review $review)
    {
        $deletForm = $this->createDeleteForm($review);

        return $this->render('review/show.html.twig', [
            'review' => $review,
            'delete_form' => $deletForm->createview(),]);
    }

    /**
     * Displays a form to edit an existing review entity.
     *
     * @Route("/{id}/edit", name="review_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, Review $review)
    {
        $deleteForm = $this->createDeleteForm($review);
        $editForm = $this->createForm('AppBundle\Form\ReviewType', $review);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('review_show', [
                'id' => $review->getId()
            ]);
        }

        return $this->render('review/edit.html.twig', [
            'review' => $review,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a review entity.
     *
     * @param Request $request Deleted posted info
     * @param Review $review The review entity
     *
     * @Route("/{id}", name="review_delete", methods="DELETE")
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Review $review)
    {
        $form = $this->createDeleteForm($review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($review);
            $em->flush();
        }

        return $this->redirectToRoute('review_index');
    }

    /**
     * Creates a form to delete a review entity.
     *
     * @param Review $review The review entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Review $review)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('review_delete', [
                'id' => $review->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;

    }

}
