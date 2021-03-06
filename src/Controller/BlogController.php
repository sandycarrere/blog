<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/blog", name="blog_")
*/
class BlogController extends AbstractController
{
    /**
 * Show all row from article's entity
 *
 * @Route("/", name="index")
 * @return Response A response instance
 */
 public function index(): Response
 {
      $articles = $this->getDoctrine()
          ->getRepository(Article::class)
          ->findAll();

      if (!$articles) {
          throw $this->createNotFoundException(
          'No article found in article\'s table.'
          );
      }

      $form = $this->createForm(
        ArticleSearchType::class,
        null,
        ['method' => Request::METHOD_GET]
      );

      return $this->render(
              'blog/index.html.twig',
              ['articles' => $articles,
              'form' => $form->createView(),
            ]
        );     
        

    
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
    
        return $this->render('/blog/show.html.twig',['cleanSlug'=>$cleanSlug]);
    }

  /* /**
     * @Route("/category/{categoryName}",
     *          methods={"GET"},
     *          name="show_category")
     */ 
 /* public function showByCategory(string $categoryName) : Response
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No category\'s name has been sent to find articles in article\'s table.');
        }
        
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($categoryName);
            
        $limit=3;    
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findByCategory($category,['id' => 'DESC'], $limit);
        return $this->render('/blog/category.html.twig', ['articles' => $articles,'category' => $category,]
        );
    }*/

          /**
     * @Route("/category/{name}", name="show_category")
     * @param Category $category
     * @return Response
     */
    //récupération en 2 temps des articles d’une catégorie en utilisant l’appel à $category->getArticles().
    //cad récupération des articles liés à la catégorie dont le nom est présent dans l'url.
    public function showByCategory(Category $category): Response
    {
        if (!$category) {
            throw $this
                ->createNotFoundException('No category has been sent to find a category in article\'s table.');
        }
        $articles = $category->getArticles();
        return $this->render('blog/category.html.twig', ['articles' => $articles, 'category' => $category]);
    }
}