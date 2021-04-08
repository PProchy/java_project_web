<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;


final class HomepagePresenter extends BasePresenter
{
    public function renderDefault(): void
    {
    }

    protected function createComponentContactForm(): Form
    {
        $form = new Form();

        $form->addText('name', 'Jméno:')
            ->addRule(Form::FILLED, 'Zadejte jméno');

        $form->addText('email', 'Email:')
            ->addRule(Form::FILLED, 'Zadejte email')
            ->addRule(Form::EMAIL, 'Email nemá správný formát');

        $form->addText('subject', 'Předmět:')
            ->addRule(Form::FILLED, 'Zadejte předmět');

        $form->addTextarea('message', 'Zpráva:')
            ->addRule(Form::FILLED, 'Zadejte zprávu');

        $form->addReCaptcha(
            'captcha', // control name
            'reCAPTCHA for you', // label
            "Prosím potvrďte, že nejste robot." // error message
        );

        $form->addSubmit('send', 'Odeslat');
        $form->onSuccess[] = [$this, 'contactFormSucceeded'];
        return $form;
    }

    public function contactFormSucceeded(Form $form, Nette\Utils\ArrayHash $values): void
    {
        $message = new Message;
        $message->addTo('xprop020@studenti.czu.cz')
            ->setFrom((string)$values['email'])
            ->setSubject('Zpráva z webu NSFD: ' . $values['subject'])
            ->setBody((string)$values['message']);

        $mailer = new SendmailMailer;
        $mailer->send($message);

        $this->presenter->flashMessage('Zpráva byla odeslána.', 'alert-success');
        $this->redirect('this');
    }


}
