<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use BlogBundle\Entity\Post;

class PostController extends Controller
{
    public function indexAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('@Blog/default/index.html.twig', [
            'posts' => $posts
        ]);
    }

    public function createAction(Request $request)
    {
        $post = new Post();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('body', TextareaType::class)
            ->add('posted_by', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_show', [
                "postId" => $post->getId()
            ]);
        }

        // replace this example code with whatever you need
        return $this->render('@Blog/default/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function showAction($postId)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($postId);

        if (!$postId) {
            throw $this->createNotFoundException(
                'No post found for id '.$postId
            );
        }

        return $this->render('@Blog/default/show.html.twig', [
            'post' => $post,
        ]);
    }
}
