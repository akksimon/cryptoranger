<?php
namespace Model;

use \Entity\News;
use \OCFram\Page;
use \OCFram\PaginatedQuery;

class NewsManagerPDO extends NewsManager
{
  protected function add(News $news)
  {
    $requete = $this->dao->prepare('INSERT INTO news SET category = :category, auteur = :auteur, titre = :titre, contenu = :contenu, dateAjout = NOW(), dateModif = NOW(), image = :image');
    
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':auteur', $news->auteur());
    $requete->bindValue(':category', $news->category());
    $requete->bindValue(':contenu', $news->contenu());
    $requete->bindValue(':image', $news->image());
    
    $requete->execute();
  }

  public function countNews()
  {
    return $this->dao->prepare('SELECT COUNT(*) FROM news WHERE category = \'news\'')->fetchColumn();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM news WHERE id = '.(int) $id);
  }

  public function getListNews($debut = -1, $limite = -1) // Get 4 last news for index.
  {
    $sql = 'SELECT id, category, auteur, titre, contenu, dateAjout, dateModif, image FROM news WHERE category = \'news\' ORDER BY id DESC';
    
    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
    
    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    $listeNews = $requete->fetchAll();
    
    foreach ($listeNews as $news)
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
    }
    
    $requete->closeCursor();
    
    return $listeNews;
  }

  public function getListOfCategory($start_page, $comments_by_page, $category)
  {
    $q = $this->dao->prepare('SELECT id, auteur, titre, contenu, dateAjout, dateModif, image FROM news WHERE category = :category ORDER BY id DESC LIMIT '.$start_page.','.$comments_by_page);
    $q->bindValue('category', $category);
    $q->execute();
    
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    $newsList = $q->fetchAll();
    
    foreach ($newsList as $news)
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
    }
    return $newsList;
  }
  
  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, category, auteur, titre, contenu, dateAjout, dateModif, image FROM news WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();
    
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    if ($news = $requete->fetch())
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
      
      return $news;
    }
    
    return null;
  }

  protected function modify(News $news)
  {
    $requete = $this->dao->prepare('UPDATE news SET category = :category, auteur = :auteur, titre = :titre, contenu = :contenu, dateModif = NOW(), image = :image WHERE id = :id');
    
    $requete->bindValue(':titre', $news->titre());
    $requete->bindValue(':auteur', $news->auteur());
    $requete->bindValue(':contenu', $news->contenu());
    $requete->bindValue(':id', $news->id(), \PDO::PARAM_INT);
    $requete->bindValue(':category', $news->category());
    $requete->bindValue(':image', $news->image());
    
    $requete->execute();
  }

  public function numberPagesNews($numberOfNewsByPage, $category)
  {
    $q = $this->dao->prepare('SELECT COUNT(*) AS allnews FROM news WHERE category = :category');
    $q->bindValue(':category', $category);
    $q->execute();
    $news = $q->fetch();
    return ceil($news['allnews'] / $numberOfNewsByPage);
  }
  
  public function getAll()
  {
   	$q = $this->dao->query('SELECT id, category, auteur, titre, contenu, dateAjout, dateModif, image FROM news ORDER BY id DESC');
    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\News');
    
    $listeNews = $q->fetchAll();
    
    foreach ($listeNews as $news)
    {
      $news->setDateAjout(new \DateTime($news->dateAjout()));
      $news->setDateModif(new \DateTime($news->dateModif()));
    }
    
    $q->closeCursor();
    
    return $listeNews;
  }
  
  public function count()
  {
   	 return $this->dao->query('SELECT COUNT(*) FROM news')->fetchColumn();
  }
  
  public function paginateNews(Page &$page, $category, $perPage)
  {
    $paginatedQuery = new PaginatedQuery(
      'SELECT id, auteur, titre, contenu, dateAjout, dateModif, image FROM news WHERE category ="'.$category.'" ORDER BY id DESC',
      'SELECT COUNT(*) FROM news WHERE category ="'.$category.'"',
      '\Entity\News',
      $perPage
    );
    $page->addVar('newsList', $paginatedQuery->getItems());
    $page->addVar('numberOfPagesNews', $paginatedQuery->getPage());
    $page->addVar('currentPage', $paginatedQuery->getCurrentPage());
  }
}