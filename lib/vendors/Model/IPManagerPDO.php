<?php
namespace Model;

use \Entity\Viewer;


class IPManagerPDO extends IPManager
{
  public function addView(Viewer $view)
  {
    $requete = $this->dao->prepare('INSERT INTO views SET ip = :ip, dateView = NOW()');
    
    $requete->bindValue(':ip', $view->ip());
    
    $requete->execute();
  }

  public function countViews()
  {
    return $this->dao->prepare('SELECT COUNT(*) FROM views')->fetchColumn();
  }
}