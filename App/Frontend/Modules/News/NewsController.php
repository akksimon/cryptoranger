<?php
namespace App\Frontend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \OCFram\FormHandler;
use \Slug\SlugGenerator;
use \OCFram\Helpers\Text;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $textLimit = new Text($this->app);
    $nombreNews = $this->app->config()->get('nombre_news_index');
        
    // On récupère le manager des news.
    $manager = $this->managers->getManagerOf('News');
    $listeNews = $manager->getListNews(0, $nombreNews);
    
    foreach ($listeNews as $news)
    {
      $news->setContenu($textLimit->excerpt($news->contenu()));
    }
    
    // On ajoute la variable $listeNews à la vue.
    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'CryptoRanger');
    $this->page->addVar('listeNews', $listeNews);
  }
  
  public function executeShowAllNews(HTTPRequest $request)
  {
    $textLimit = new Text($this->app);
    $this->managers->getManagerOf('News')->paginateNews($this->page, $request->getData('category'), (int)$this->app->config()->get('nombre_news_by_page'));
   
    $newsList = $this->page->getVar('newsList');
    foreach ($newsList as $news)
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
      $news->setContenu($textLimit->excerpt($news->contenu()));
    }

    $this->page->addVar('category', $request->getData('category'));
    $this->page->addVar('title', 'All News');
    $this->page->addVar('newsList', $newsList);
  }
 
  public function executeShowNews(HTTPRequest $request)
  {
    $this->managers->getManagerOf('Comments')->paginateComments($this->page, $request->getData('id'), (int)$this->app->config()->get('number_comments_by_page'));
    
    $news = $this->managers->getManagerOf('News')->getUnique($request->getData('id'));
    if (empty($news))
    {
      $this->app->httpResponse()->redirect404();
    }
    if ($request->method() == 'POST'){
      $this->insertComment($request, $news->titre(), $news->category());
    }
    /* Generation du formulaire de commentaires */
    $formBuilder = new CommentFormBuilder($comment = new Comment);
    $formBuilder->build();
    $form = $formBuilder->form();

    $commentsList = $this->page->getVar('comments');
    foreach ($commentsList as $comment)
    {
      $comment->setDate(new \DateTime($comment->date()));
    }
    
    $this->page->addVar('title', $news->titre());
    $this->page->addVar('news', $news);
    $this->page->addVar('comments', $commentsList);
    $this->page->addVar('form', $form->createView());
  }
  
  public function insertComment($request, $title, $category)
  {
    $secretKey = "6LdkRKQUAAAAACx3MPJoOyOoI54h6R5NA8UwxFO8";
    $response = $_POST['g-recaptcha-response'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . '&response=' . $response . '&remoteip=' . $ip;

    
    $decode = json_decode(file_get_contents($api_url), true);

    if ($decode['success']){
      $comment = new Comment([
      'news' => $request->getData('id'),
      'auteur' => $request->postData('auteur'),
      'contenu' => $request->postData('contenu')
      ]);

      $formBuilder = new CommentFormBuilder($comment);
      $formBuilder->build();
      $form = $formBuilder->form();
      $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

      if ($formHandler->process())
      {
        $this->app->user()->setFlashComment('thanks for your comment!');
        $generator = new SlugGenerator;
        if ($category === 'news'){
          $this->app->httpResponse()->redirect('/news/'.$generator->generate($title).'_'.$request->getData('id'));
        }else {
          $this->app->httpResponse()->redirect('/guide/'.$category.'/'.$generator->generate($title).'_'.$request->getData('id'));
        }
      }
    }    
  }
}