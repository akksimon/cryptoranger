<?php
namespace Model;

use \Entity\News;

class GuidesManagerPDO extends GuidesManager
{
  protected function add(News $guide)
  {
    $requete = $this->dao->prepare('INSERT INTO guides SET category = :category, auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');
    
    $requete->bindValue(':category', $guide->category());
    $requete->bindValue(':titre', $guide->titre());
    $requete->bindValue(':auteur', $guide->auteur());
    $requete->bindValue(':contenu', $guide->contenu());
    
    $requete->execute();
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM guides')->fetchColumn();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM guides WHERE id = '.(int) $id);
  }

  public function getGuides($category)
  {
    $requete = $this->dao->prepare('SELECT id, category, auteur, titre, contenu, dateAjout, dateModif, image FROM guides WHERE category = :category ORDER BY id DESC');
    $requete->bindValue(':category', $category);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    $listeGuides = $requete->fetchAll();
    
    foreach ($listeGuides as $guide)
    {
      $guide->setDateAjout(new \DateTime($guide->dateAjout()));
      $guide->setDateModif(new \DateTime($guide->dateModif()));
    }
    
    $requete->closeCursor();
    
    return $listeGuides;
  }
  
  public function getUniqueGuide($id)
  {
    $requete = $this->dao->prepare('SELECT id, category, auteur, titre, contenu, dateAjout, dateModif, image FROM guides WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();
    
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    if ($guide = $requete->fetch())
    {
      $guide->setDateAjout(new \DateTime($guide->dateAjout()));
      $guide->setDateModif(new \DateTime($guide->dateModif()));
      
      return $guide;
    }
    return null;
  }

  protected function modify(News $news)//
  {
    $requete = $this->dao->prepare('UPDATE news SET auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW() WHERE id = :id');
    
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':auteur', $news->auteur());
    $requete->bindValue(':contenu', $news->contenu());
    $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);
    
    $requete->execute();
  }
}