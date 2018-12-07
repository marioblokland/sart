<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Article;

class ArticleController extends Controller
{
    /**
     * @Route("/", name="list_articles")
     * @Method({"GET"})
     */
    public function index(): Response
    {
        //return new Response('<html><body>Hello</body></html>');
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        
        return $this->render('articles/index.html.twig', ['articles' => $articles]);
    }
    
    
    /**
     * @Route("/article/new", name="new_article")
     * @Method({"GET", "POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request Symfony request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        
        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
                     ->add('body', TextareaType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
                     ->add('save', SubmitType::class,
                         ['label' => 'Create', 'attr' => ['class' => 'btn btn-primary mt-3']])
                     ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            
            return $this->redirectToRoute('list_articles');
        }
        
        return $this->render('articles/new.html.twig', ['form' => $form->createView()]);
    }
    
    
    /**
     * @Route("/article/{id}", name="show_article")
     * @param int $id Article ID.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(int $id): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        
        return $this->render('articles/show.html.twig', ['article' => $article]);
    }
    
    
    /**
     * @Route("/article/delete/{id}", name="delete_article")
     * @Method({"DELETE"})
     * @param int $id Article ID.
     */
    public function delete(int $id): void
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        
        (new Response())->send();
    }
    
    
    /**
     * @Route("/article/edit/{id}", name="edit_article")
     * @Method({"GET", "POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request Symfony request
     *
     * @param int                                       $id      Article ID.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, int $id): Response
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        
        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
                     ->add('body', TextareaType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
                     ->add('save', SubmitType::class,
                         ['label' => 'Edit', 'attr' => ['class' => 'btn btn-primary mt-3']])
                     ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            
            return $this->redirectToRoute('list_articles');
        }
        
        return $this->render('articles/edit.html.twig', ['form' => $form->createView()]);
    }
    
    
    
    /**
     * @Route("/article/save")
     */
    /*    public function save(): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            
            $article = new Article();
            $article->setTitle('Article One');
            $article->setBody('This is the body for article one');
            
            $entityManager->persist($article);
            $entityManager->flush();
            
            return new Response('Saved an article with the ID ' . $article->getId());
        }*/
}

