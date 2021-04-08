<?php


namespace App\Forms;


use Nette\Application\UI\Form;

final class LoginFormFactory
{
    /** @var BaseFormFactory */
    private $baseFormFactory;

    /**
     * @param BaseFormFactory $baseFormFactory
     */
    public function __construct(BaseFormFactory $baseFormFactory)
    {
        $this->baseFormFactory = $baseFormFactory;
    }

    public function create(): Form
    {
        $form = $this->baseFormFactory->create();

        $form->addEmail('email', 'Email:')
            ->setRequired('Zadejte prosím email.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Zadejte prosím heslo.');

        $form->addSubmit('send', 'Přihlásit se');

        return $form;
    }
}