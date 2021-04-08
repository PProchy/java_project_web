<?php


namespace App\Forms;


use Nette\Application\UI\Form;

final class RatingFormFactory
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

        $form->addTextArea('text', 'Popis:')
            ->setRequired('Zadejte prosím popis.');

        $form->addInteger('percent', 'Hodnocení:')
            ->setRequired('Zadejte prosím hodnocení.')
            ->addRule($form::RANGE, 'Hodnocení musí být v rozsahu mezi %d a %d.', [0, 100]);

        $form->addSubmit('send', 'Odeslat hodnocení');

        return $form;
    }
}