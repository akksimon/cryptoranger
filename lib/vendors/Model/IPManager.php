<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Viewer;

abstract class IPManager extends Manager
{

  /**
   * Méthode permettant d'ajouter une news.
   * @param $news News La news à ajouter
   * @return void
   */
  abstract public function addView(Viewer $view);

  /**
   * Méthode renvoyant le nombre de vues totales.
   * @return int
   */
  abstract public function countViews();


 
}