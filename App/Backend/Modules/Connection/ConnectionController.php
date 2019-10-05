<?php

namespace App\Backend\Modules\Connection;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class ConnectionController extends BackController
{
	public function executeIndex(HTTPRequest $request)
    {
	    $this->page->addVar('title', 'Connection');
	    
	    if ($request->postExists('login'))
	    {
	      $login = $request->postData('login');
	      $password = $request->postData('password');
	      
	      if ($login == $this->app->config()->get('login') && $password == $this->app->config()->get('pass'))
	      {
	        $this->app->user()->setAuthenticated(true);
	        $this->app->httpResponse()->redirect('.');
	      }
	      else
	      {
	        $this->app->user()->setFlash('invalid login or password.');
      	  }	
  		}
    }
}