<?php
namespace Entity;

use \OCFram\Entity;

class Viewer extends Entity
{
  protected $ip,
            $dateView;

  const IP_INVALID = 1;

  public function isValid()
  {
    return !(empty($this->ip));
  }


  // SETTERS //

  public function setIp($ip)
  {
    if (!filter_var($ip, FILTER_VALIDATE_IP))
    {
      $this->erreurs[] = self::IP_INVALID;
    }
    $this->ip = $ip;
  }

  public function setDateView(\DateTime $dateView)
  {
    $this->dateView = $dateView;
  }

  // GETTERS //

  public function ip()
  {
    return $this->ip;
  }

  public function dateView()
  {
    return $this->dateView;
  }
}