<?php
namespace Model;

use \OCFram\Manager;
use \Entity\News;
use \OCFram\Page;

abstract class NewsManager extends Manager
{

  /**
   * Méthode permettant d'ajouter une news.
   * @param $news News La news à ajouter
   * @return void
   */
  abstract protected function add(News $news);
  
  /**
   * Méthode permettant d'enregistrer une news.
   * @param $news News la news à enregistrer
   * @see self::add()
   * @see self::modify()
   * @return void
   */
  public function save(News $news)
  {
    if ($news->isValid())
    {
      $news->isNew() ? $this->add($news) : $this->modify($news);
    }
    else
    {
      throw new \RuntimeException('La news doit être validée pour être enregistrée');
    }
  }

  /**
   * Méthode renvoyant le nombre de news total.
   * @return int
   */
  abstract public function countNews();

  /**
   * Méthode permettant de supprimer une news.
   * @param $id int L'identifiant de la news à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode retournant une liste de news demandée.
   * @param $debut int La première news à sélectionner
   * @param $limite int Le nombre de news à sélectionner
   * @return array La liste des news. Chaque entrée est une instance de News.
   */
  abstract public function getListNews($debut = -1, $limite = -1);
  
  /**
   * Méthode retournant une news précise.
   * @param $id int L'identifiant de la news à récupérer
   * @return News La news demandée
   */
  abstract public function getUnique($id);

  /**
   * Méthode permettant de modifier une news.
   * @param $news news la news à modifier
   * @return void
   */
  abstract protected function modify(News $news);

  abstract public function numberPagesNews($numberOfNewsByPage, $category);

  // GUIDES

  /**
   * Méthode permettant de récupérer tous les guides d'une catégorie (started, funds, trading).
   * @param $category la catégore du guide à rechercher.
   * @return array La liste des news. Chaque entrée est une instance de News avec catégorie (started, funds, trading).
   */

  abstract public function getListOfCategory($start_page, $comments_by_page, $category);
  abstract public function getAll();
  abstract public function count();
  abstract  public function paginateNews(Page &$page, $category, $perPage);
}