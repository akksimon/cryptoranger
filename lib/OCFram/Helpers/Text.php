<?php

namespace OCFram\Helpers;

use \OCFram\ApplicationComponent;

class Text extends ApplicationComponent
{
    public function excerpt(string $content)
    {
        $numberCaracters = $this->app->config()->get('nombre_caracteres_news');

		if (strlen($content) > $numberCaracters)
      	{
     	    $debut = substr($content, 0, $numberCaracters);
       		$debut = substr($debut, 0, strrpos($debut, ' ')) . '<span class="threepoint">...</span>';
        	return $debut;
      	}
      	return $content;
    }
}