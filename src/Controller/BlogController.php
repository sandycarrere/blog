<?php
// src/Controller/BlogController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/blog", name="blog_")
*/
class BlogController extends AbstractController
{
    /**
    * @Route("/", name="index")
    */
    public function index()
    {
        
        return $this->render('blog/index.html.twig', ['owner' => 'Thomas']);
    }
    /**
     * @Route("/show/{slug}",
     *          methods={"GET"},
     *          requirements={"slug"="[a-z0-9\-]+"},
     *          defaults={"slug"="article-sans-titre"},
     *          name="show")
     */
    public function show(string $slug)
    {
        $cleanSlug = ucwords(trim(str_replace('-',' ',$slug)));
    
        return $this->render('blog/show.html.twig',['cleanSlug'=>$cleanSlug]);
    }
}