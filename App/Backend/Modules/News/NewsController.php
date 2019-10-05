<?php
namespace App\Backend\Modules\News;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\News;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\NewsFormBuilder;
use \OCFram\FormHandler;

class NewsController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'News Managment');

    $manager = $this->managers->getManagerOf('News');

    $this->page->addVar('listeNews', $manager->getAll());
    $this->page->addVar('nombreNews', $manager->count());
  }
  
  public function executeEdit(HTTPRequest $request)
  {
    $this->processForm($request);

    $this->page->addVar('title', 'Edit News');
  }
  
  public function executeInsert(HTTPRequest $request)
  {
    $this->processForm($request);

    $this->page->addVar('title', 'Post news');
  }
  
  public function processForm(HTTPRequest $request)
  {
   	if ($request->method() == 'POST') {
      	$news = new News([
      	'auteur' => $request->postData('auteur'),
      	'titre' => $request->postData('titre'),
      	'contenu' => $request->postData('contenu'),
        'category' => $request->postData('category'),
        'image' => $request->postData('image')
      	]);
      
        if ($request->getExists('id')){
        $news->setId($request->getData('id'));
   		}
    } else {
      	if ($request->getExists('id')) {
         	$news = $this->managers->getManagerOf('News')->getUnique($request->getData('id')); 
        } else {
         	$news = new News; 
        }	
    }
    
    $formBuilder = new NewsFormBuilder($news);
    $formBuilder->build();

    $form = $formBuilder->form();

    if ($request->method() == 'POST' && $form->isValid())
    {
      $this->managers->getManagerOf('News')->save($news);
      $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');
      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
   }
            
  public function executeDelete(HTTPRequest $request)
  {
    $this->managers->getManagerOf('News')->delete($request->getData('id'));
    $this->managers->getManagerOf('Comments')->deleteFromNews($request->getData('id'));
    
    $this->app->user()->setFlash('La news a bien été supprimée !');
    
    $this->app->httpResponse()->redirect('.');
  }
}