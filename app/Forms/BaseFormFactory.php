<?php


namespace App\Forms;

use Nette\Application\UI\Form;

final class BaseFormFactory
{
    public function create(): Form
    {
        //$form->setTranslator();
        //$form->addProtection();

        return new Form();
    }
}