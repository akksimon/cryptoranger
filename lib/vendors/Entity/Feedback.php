<?php
namespace Entity;

use \OCFram\Entity;

class Feedback extends Entity
{
  protected $name,
            $mail,
            $feedback,
            $dateFeed;

  const NAME_LIMIT_INF = 3;
  const NAME_LIMIT_MAX = 20;
  const FEEDBACK_LIMIT_MAX = 1000;
  const FEEDBACK_LIMIT_MIN = 10;


  public function isValid()
  {
    return !(empty($this->name) || empty($this->mail) || empty($this->feedback));
  }

  // SETTERS //

  public function setName($name)
  {
    if (!is_string($name) || empty($name) || ((strlen($name) < self::NAME_LIMIT_INF) || strlen($name) > self::NAME_LIMIT_MAX))
    {
      $this->erreurs['name'] = 'Your name is not correct';
    }else {
       $this->name = $name;
    }
  }

  public function setMail($mail)
  {
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
    {
      $this->erreurs['mail'] = 'Your email is not valid';
    }else {
      $this->mail = $mail;
    }
  }

  public function setFeedback($feedback)
  {
    if (!is_string($feedback) || empty($feedback) || ((strlen($feedback) < self::FEEDBACK_LIMIT_MIN) || (strlen($feedback) > self::FEEDBACK_LIMIT_MAX)))
    {
      $this->erreurs['feedback'] = 'Your feedback is not correct';
    }else {
      $date = new \DateTime();
      $this->feedback = json_encode([
                                      'date' => $date->format('Y-m-d  Hi'),
                                      'feedback' => $feedback,
                                   ], JSON_UNESCAPED_UNICODE);
    }
  }

  public function modifyFeedback($feedback)
  {
    $this->feedback = $feedback;
  }
  
  public function setDateFeed(\DateTime $date)
  {
    $this->dateFeed = $date;
  }


  // GETTERS //

  public function name()
  {
    return $this->name;
  }

  public function mail()
  {
    return $this->mail;
  }

  public function feedback()
  {
    return $this->feedback;
  }

  public function dateFeed()
  {
    return $this->dateFeed;
  }
}