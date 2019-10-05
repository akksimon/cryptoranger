<?php
namespace Model;
use \Entity\Feedback;


class FeedbackManagerPDO extends FeedbackManager
{
	public function add(Feedback $feed)
    {
      $requete = $this->dao->prepare('INSERT INTO feedback SET name = :name, mail = :mail, feedback = :feedback, dateFeed = NOW()');
    
      $requete->bindValue(':name', $feed->name());
      $requete->bindValue(':mail', $feed->mail());
      $requete->bindValue(':feedback', $feed->feedback());
    
      $requete->execute();
    }

  public function countFeed()
  {
    return $this->dao->prepare('SELECT COUNT(*) FROM feedback')->fetchColumn();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM feedback WHERE id = '.(int) $id);
  }

  public function getListOfFeedback($start_page, $comments_by_page)
  {
    $q = $this->dao->query('SELECT * FROM feedback LIMIT '.$start_page.','.$comments_by_page);
    
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Feedback');
    
    $feedbackList = $q->fetchAll();
    
    foreach ($feedbackList as $feed)
    {
      $feed->setDateFeed(new \DateTime($feed->dateFeed()));
    }
    return $feedbackList;
  }
  
  public function modify(Feedback $feed)
  {
    $requete = $this->dao->prepare('UPDATE feedback SET name = :name, mail = :mail, feedback = :feedback, dateFeed = NOW() WHERE id = :id');
    
    $requete->bindValue(':name', $feed->name());
    $requete->bindValue(':mail', $feed->mail());
    $requete->bindValue(':feedback', $feed->feedback());
    $requete->bindValue(':id', $feed->id(), \PDO::PARAM_INT);
    
    $requete->execute();
  }

  public function getFeedback($mail)
  {
    $requete = $this->dao->prepare('SELECT * FROM feedback WHERE mail = :mail');
    $requete->bindValue(':mail', $mail);
    $requete->execute();
    
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Feedback');
    
    if ($feed = $requete->fetch())
    {
      $feed->setDateFeed(new \DateTime($feed->dateFeed()));
      
      return $feed;
    }
    return null;
  }

  public function numberPagesFeed($numberOfFeedByPage)
  {
    $q = $this->dao->query('SELECT COUNT(*) AS allfeed FROM feedback');

    $feed = $q->fetch();
    return ceil($feed['allfeed'] / $numberOfFeedByPage);
  }

  public function mailExists(Feedback $feed)
  {
  	$q = $this->dao->prepare('SELECT COUNT(*) FROM feedback WHERE mail = :mail');
  	$q->bindValue(':mail', $feed->mail());
  	$q->execute();
  	$result = $q->fetch();
  	if ($result[0] != 0){
  		return true;
  	}
  	return false;
  }
}