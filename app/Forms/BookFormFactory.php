<?php


namespace App\Forms;


use App\Model\UserFacade;
use Nette\Application\UI\Form;

final class BookFormFactory
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

    public function create(UserFacade $userFacade): Form
    {
        $form = $this->baseFormFactory->create();

        $people = $userFacade->getPairUser();
        $people['null'] = 'Nikdo';

        $form->addText('name', 'Název:')
            ->setRequired('Zadejte název.');

        $form->addInteger('pages', 'Počet stran:')
            ->setRequired('Zadejte počet stran.');

        $form->addRadioList("is_borrowed", "Je půjčeno?:", ['0' => 'Ne', '1' => 'Ano'])
            ->setRequired('Zadejte prosím zda je půjčeno..')
            ->setDefaultValue(0);

        $form->addSelect('user_id', 'Půjčeno uživatelem:', $people)
            ->setDefaultValue('null');

        $form->addSubmit('send', 'Přidat/upravit knihu');

        return $form;
    }

    /**
     * @param $values
     */
    public function setDefaults($values): void
    {
        $this['bookForm']->setDefaults($values);
    }
}