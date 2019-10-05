<?php
namespace Entity;

use \OCFram\Entity;

class Guide extends Entity
{
  protected $auteur,
            $category,
            $titre,
            $contenu,
            $image,
            $dateAjout,
            $dateModif;

  const INVALID_CATEGORY = 5;
  const AUTEUR_INVALID = 1;
  const TITRE_INVALID = 2;
  const CONTENU_INVALID = 3;
  const IMAGE_NOT_VALID = 4;

  public function isValid()
  {
    return !(empty($this->auteur) || empty($this->titre) || empty($this->contenu));
  }


  // SETTERS //

  public function setAuteur($auteur)
  {
    if (!is_string($auteur) || empty($auteur))
    {
      $this->erreurs[] = self::AUTEUR_INVALID;
    }

    $this->auteur = $auteur;
  }

  public function setImage($image)      /* AJOUTER REGEXP CHECK IMAGE */
  {
    if (!is_string($image) || empty($image))
    {
      $this->erreurs[] = self::IMAGE_NOT_VALID;
    }
      $this->image = $image;
  }

  public function setTitre($titre)
  {
    if (!is_string($titre) || empty($titre))
    {
      $this->erreurs[] = self::TITRE_INVALID;
    }

    $this->titre = $titre;
  }

  public function setContenu($contenu)
  {
    if (!is_string($contenu) || empty($contenu))
    {
      $this->erreurs[] = self::CONTENU_INVALID;
    }

    $this->contenu = $contenu;
  }

  public function setDateAjout(\DateTime $dateAjout)
  {
    $this->dateAjout = $dateAjout;
  }

  public function setDateModif(\DateTime $dateModif)
  {
    $this->dateModif = $dateModif;
  }

  // GETTERS //

  public function auteur()
  {
    return $this->auteur;
  }

  public function image()
  {
    return $this->image;
  }

  public function titre()
  {
    return $this->titre;
  }

  public function contenu()
  {
    return $this->contenu;
  }

  public function dateAjout()
  {
    return $this->dateAjout;
  }

  public function dateModif()
  {
    return $this->dateModif;
  }
}