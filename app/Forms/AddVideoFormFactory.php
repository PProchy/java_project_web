<?php


namespace App\Forms;


use Nette\Application\UI\Form;

final class AddVideoFormFactory
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
            ->setRequired('Zadejte název videa.');

        $form->addTextArea('description', 'Popis:')
            ->setRequired('Zadejte prosím popis');

        $form->addRadioList("category_id", "Kategorie:", ['1' => 'Film', '2' => 'Seriál'])
            ->setRequired('Zadejte prosím kategorii.');

        $form->addText('country', 'Místo vzniku:')
            ->setRequired('Zadejte prosím místo vzniku.');

        $form->addText('year', 'Datum vzniku:')
            ->setRequired('Zadejte prosím datum vzniku.');

        $form->addText('time', 'Minutáž:')
            ->setRequired('Zadejte prosím minutáž.');

        $form->addUpload('photo', 'Obrázek k náhledu:')
            ->addRule(Form::IMAGE, 'Obrázek musí být formátu JPEG, PNG nebo GIF.')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost je 4 mB.', 4 * 1024 * 1024)
            ->setRequired('Zadejte prosím obrázek.');

        $form->addSubmit('send', 'Přidat video');

        return $form;
    }
}