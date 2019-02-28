<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Question;
use App\Entity\Comment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class QuestionsController extends AbstractController
{
    /**
     * @Route("/questions/recentes", name="last_questions")
     */
    public function lastQuestions()
    {
        
        $questionRepository = $this->getDoctrine()
            ->getRepository(Question::class);

        $questions = $questionRepository->findBy([],["dateCreaed"=> "DESC"],30);

        return $this->render('questions/last_questions.html.twig',[
            'questions' => $questions
        ]);
    }

    /**
     * @Route("/question/{id}", name="question_show")
     */
    public function show($id)
    {
        
        $question_show = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($id);

        
        if (!$question_show) {
            throw $this->createNotFoundException(
                'No question found for id '.$id
            );
        }

        $commentRepository = $this->getDoctrine()
        ->getRepository(Comment::class);

        $comments = $commentRepository->findBy([],["dateCreated"=> "DESC"],30);

        return $this->render('questions/question_show.html.twig', [
            'questions' => $question_show,
            'comments' => $comments
            ]);

    }

    /**
     * @Route("/ajouter/question", name="add_question")
     */
    public function addQuestion(Request $request, ObjectManager $manager) 
    {
        $newQuestion = new Question();

        $formQuestion = $this->createFormBuilder($newQuestion)
            ->add('title')
            ->add('description')
            ->getForm();

        $formQuestion->handleRequest($request);

        if ($formQuestion->isSubmitted() && $formQuestion->isValid()) {

            $newQuestion->setDateCreaed(new \DateTime);

            $manager->persist($newQuestion);
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash('success','Merci pour votre contribution');

            return $this->redirectToRoute('last_questions');
                


        }
        
        return $this->render('questions/add_question.html.twig',[
            'formNewQuestion' => $formQuestion->createView()
        ]);
    }
}
