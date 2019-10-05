<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Feedback;

abstract class FeedbackManager extends Manager
{
	/**
   * Méthode permettant d'ajouter une feedback a la BDD.
   * @param $feeds la feedback
   * @return void
   */
  abstract public function add(Feedback $feed);

  /**
   * Méthode renvoyant le nombre de feedback total.
   * @return int
   */
  abstract public function countFeed();

  /**
   * Méthode permettant de supprimer une feedback.
   * @param $id int L'identifiant de la feedback à supprimer
   * @return void
   */
  abstract public function delete($id);
  
  /**
   * Méthode retournant une news précise.
   * @param $mail le mail de la feedback a récupérer.
   * @return Feedback.
   */
  abstract public function getFeedback($mail);

  /**
   * Méthode permettant de modifier une news.
   * @param $news news la news à modifier
   * @return void
   */

  	/**
   * Méthode permettant de modifier une feedback.
   * @param $feed feed la feedback à modifier
   * @return void
   */
  abstract public function modify(Feedback $feed);

  abstract public function numberPagesFeed($numberOfFeedByPage);

  // GUIDES

  /**
   * Méthode permettant de récupérer tous les guides d'une catégorie (started, funds, trading).
   * @param $category la catégore du guide à rechercher.
   * @return array La liste des news. Chaque entrée est une instance de News avec catégorie (started, funds, trading).
   */

  abstract public function getListOfFeedback($start_page, $comments_by_page);

  abstract public function mailExists(Feedback $feed);


}