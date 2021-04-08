<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms\AddressFormFactory;
use App\Forms\BookFormFactory;
use App\Forms\UserFormFactory;
use App\Model\AddressFacade;
use App\Model\BookFacade;
use App\Model\UserFacade;
use Nette;


class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var UserFacade @inject */
    public $userFacade;

    /** @var BookFacade @inject */
    public $bookFacade;

    /** @var AddressFacade @inject */
    public $addressFacade;

    /** @var AddressFormFactory @inject */
    public $addressFormFactory;

    /** @var BookFormFactory @inject */
    public $bookFormFactory;

    /** @var UserFormFactory @inject */
    public $userFormFactory;

}
