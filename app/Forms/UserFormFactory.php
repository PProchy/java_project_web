<?php


namespace App\Forms;


use App\Model\AddressFacade;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\Checkbox;

final class UserFormFactory
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

    public function create(AddressFacade $addressFacade): Form
    {
        $form = $this->baseFormFactory->create();

        $addresses = $addressFacade->getPairAddress();

        $form->addText('name', 'Jméno:')
            ->setRequired('Zadejte jméno.');

        $form->addText('surname', 'Příjmení:')
            ->setRequired('Zadejte příjmení.');

        $form->addText('birth', 'Datum narození:')
            ->setRequired('Zadejte datum narození.')
            ->setHtmlType('date');

        $form->addSelect('address_id', 'Adresa:', $addresses)
            ->setRequired('Zadejte adresu.');

        $form->addSubmit('send', 'Přidat/upravit uživatele');

        return $form;
    }

    /**
     * @param $values
     */
    public function setDefaults($values): void
    {
        $this['userForm']->setDefaults($values);
    }
}