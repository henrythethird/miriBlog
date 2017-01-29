<?php

namespace AppBundle\Service;

use AppBundle\Aggregate\Contact;

class ContactService {
	private $mailer;

	public function __construct(\Swift_Mailer $mailer) {
		$this->mailer = $mailer;
	}

	public function sendMessage(Contact $contact) {
		$message = new \Swift_Message(
			"Contact Request Kuchenkrümel.ch - ".$contact->getName(),
			"Name: ".$contact->getName()."
			E-Mail: ".$contact->getEmail()."
			Message: 
			".$contact->getText()
		);

		$message->setReplyTo("info@kuchenkruemel.ch");
		$message->setTo("info@kuchenkruemel.ch");
		$this->mailer->send($message);
	}
}