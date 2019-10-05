<?php
namespace App\Frontend\Modules\Feedback;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Feedback;

class FeedbackController extends BackController
{
	protected $email = 'symacademy@gmail.com';

	public function executeIndex(HTTPRequest $request)
	{
		if ($request->method() != 'POST'){
			$this->app->httpResponse()->redirect404();
		}

		$feedback = new Feedback([
	      'name' => $request->postData('name'),
	      'mail' => $request->postData('mail'),
	      'feedback' => $request->postData('feedback')
	      ]);

      	if (!$feedback->isValid()) {
			$_SESSION['FeedBackError'] = $feedback->erreurs();
			$this->app->httpResponse()->redirect('/');
		}
		// Coder méthode Feedback check si toutes les données sont conformes...


		$manager = $this->managers->getManagerOf('Feedback');
		if (!$manager->mailExists($feedback)){
			$manager->add($feedback);
			$this->app->user()->setFlashFeed('Thank you for your message!');
			$this->sendMail($feedback);
			$this->app->httpResponse()->redirect('/#contact');
		}else {
			$previousFeed = $manager->getFeedback($feedback->mail());
			$feedbackUpdate = $previousFeed->feedback()."\n\n".$feedback->feedback();
			$previousFeed->modifyFeedback($feedbackUpdate);
			$manager->modify($previousFeed);
			$this->app->user()->setFlashFeed('Thank you for your new message!');
			$this->sendMail($feedback);
			$this->app->httpResponse()->redirect('/#contact');
		}
	}

	public function sendMail($feedback)
	{
		$objet = 'New message from : '. htmlentities($feedback->name());

		$feedmail = '<html><head><title> '.'Feedback from CryptoRanger website'.' </title></head><body>';
		$feedmail .= '<p>Tu as un nouveau message !</p>';
		$feedmail .= '<p><strong>Nom</strong>: '.$feedback->name().'</p>';
		$feedmail.= '<p><strong>Message</strong>: '.$feedback->feedback().'</p>';
		$feedmail .= '</body></html>'; // Contenu du message de l'email (en XHTML)

		$headers = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
		mail($this->email, $objet, $feedmail, $headers); // Fonction principale qui envoi l'email // Paramétrer serveur envoi de mail
	}

	public function setEmail($email)
	{
		if (is_string($email)){
			$this->email = $email;
		}
	}
}