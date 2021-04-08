<?php


namespace App\Forms;


use Nette\Application\UI\Form;

final class RegistrationFormFactory
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

        $form->addText('name', 'Jméno:')
            ->setRequired('Zadejte prosím jméno.');

        $form->addText('surname', 'Příjmení:')
            ->setRequired('Zadejte prosím příjmení.');

        $form->addEmail('email', 'Email:')
            ->setRequired('Zadejte prosím email.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Zadejte prosím heslo.')
            ->addRule($form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 6);

        $form->addPassword('passwordVerify', 'Heslo pro kontrolu:')
            ->setRequired('Zadejte prosím heslo ještě jednou pro kontrolu.')
            ->addRule($form::EQUAL, 'Hesla se neshodují.', $form['password'])
            ->setOmitted();

        $form->addCheckbox('agree', 'Souhlasím s podmínkami')
            ->setRequired('Musíte souhlasit se zpracováním osobních údajů.')
            ->setOmitted();

        $form->addSubmit('send', 'Zaregistrovat se');

        return $form;
    }
}