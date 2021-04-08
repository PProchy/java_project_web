<?php


namespace App\Forms;


use Nette\Application\UI\Form;

final class EditVideoFormFactory
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

        $form->addText('name', 'Název:')
            ->setOmitted();

        $form->addRadioList("is_favorite", "Oblíbený:", ['0' => 'Ne', '1' => 'Ano'])
            ->setRequired('Zadejte prosím zda je oblíbený.');

        $form->addRadioList("is_recommended", "Doporučený:", ['0' => 'Ne', '1' => 'Ano'])
            ->setRequired('Zadejte prosím zda je doporučený.');

        $form->addSubmit('send', 'Upravit video');

        return $form;
    }

    /**
     * @param $values
     */
    public function setDefaults($values): void
    {
        $this['editVideoForm']->setDefaults($values);
    }
}