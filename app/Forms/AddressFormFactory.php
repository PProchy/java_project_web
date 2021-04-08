<?php


namespace App\Forms;


use Nette\Application\UI\Form;

final class AddressFormFactory
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

        $form->addText('street', 'Ulice:')
            ->setRequired('Zadejte ulici.');

        $form->addText('house_number', 'Číslo popisné:')
            ->setRequired('Zadejte číslo popisné.');

        $form->addText('postal_code', 'PSČ:')
            ->setRequired('Zadejte PSČ.');

        $form->addText('city', 'Město:')
            ->setRequired('Zadejte město.');

        $form->addText('state', 'Stát:')
            ->setRequired('Zadejte stát.');

        $form->addSubmit('send', 'Přidat/upravit adresu');

        return $form;
    }

    /**
     * @param $values
     */
    public function setDefaults($values): void
    {
        $this['addressForm']->setDefaults($values);
    }
}