<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Comment;
use App\Form\CommentType;

class CommentController extends AbstractController
{
    /**
     * @Route("/commentaire", name="comment_create")
     */
    public function commentCreate(Request $request, ObjectManager $manager)
    {

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()){

            $comment->setDateCreated(new \DateTime);

            $manager->persist($comment);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash('success','Merci pour votre contribution');

            return $this->redirectToRoute('last_comments');
            

        }

        return $this->render('comment/comment_create.html.twig',[
            'formComment' => $formComment->createView()
        ]);
    }

    /**
     * @Route("/commentaires/recents", name="last_comments")
     */
    public function lastComments() {

     $commentRepository = $this->getDoctrine()
        ->getRepository(Comment::class);

    $comments = $commentRepository->findBy([],["dateCreated"=> "DESC"],30);

    return $this->render('comment/last_comments.html.twig',[
        'comments' => $comments
        ]);

    }
}
