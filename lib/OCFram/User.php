<?php
namespace OCFram;
use \Entity\Viewer;

session_start();

class User extends ApplicationComponent
{
  const ERROR_FEEDBACK = ['mail', 'name', 'feedback'];
  
  public function __construct(Application $app)
  {
    parent::__construct($app);
    $this->incrementViews();
  }

  public function getAttribute($attr)
  {
    return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;
  }

  public function getFlash()
  {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
  }
  
  public function getFlashComment()
  {
    $flash = $_SESSION['flashcomment'];
    unset($_SESSION['flashcomment']);

    return $flash;
  }

  public function getFlashFeedback()
  {
    $flash = $_SESSION['feedback'];
    unset($_SESSION['feedback']);

    return $flash;
  }
  
  public function getFlashFeed($field)
  {
    if (isset($_SESSION['FeedBackError'][$field])){
      $error = $_SESSION['FeedBackError'][$field];
      unset($_SESSION['FeedBackError'][$field]);
      return $error;
    }
    return null;
  }

  public function hasFlash()
  {
    return isset($_SESSION['flash']);
  }

  public function hasFeed($field)
  {
    return isset($_SESSION['FeedBackError'][$field]);
  }

  public function hasFeedback()
  {
    return isset($_SESSION['feedback']);
  }
  
  public function hasComment()
  {
    return isset($_SESSION['flashcomment']);
  }
  
  public function hasIp()
  {
    return isset($_SESSION['ip']);
  }

  public function isAuthenticated()
  {
    return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
  }

  public function setAttribute($attr, $value)
  {
    $_SESSION[$attr] = $value;
  }

  public function setAuthenticated($authenticated = true)
  {
    if (!is_bool($authenticated))
    {
      throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');
    }

    $_SESSION['auth'] = $authenticated;
  }

  public function setFlash($value)
  {
    $_SESSION['flash'] = $value;
  }
  
  public function setFlashFeed($value)
  {
   	$_SESSION['feedback'] = $value; 
  }

  public function setFeed($value)
  {
    $_SESSION['FeedBackError'] = $value;
  }
  
  public function setFlashComment($value)
  {
   	$_SESSION['flashcomment'] = $value; 
  }

  public function setIp($ip)
  {
    $_SESSION['ip'] = $ip;
  }

  /**
 * Ajoute une vue à la base de donnée à chaque connection au site.
 *
 *@param Ajoute l'Ip du viewer à la database.
 *
 *@return void
 */
  public function incrementViews()
  {
    $ip_user = $this->app->httpRequest()->requestIP();
    $managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
    $manager = $managers->getManagerOf('IP');

    $view = new Viewer([
                  'ip' => $ip_user
                ]);
    if (!$this->hasIp()) {
      $manager->addView($view);
      $this->setIp($ip_user);
    }
  }
}