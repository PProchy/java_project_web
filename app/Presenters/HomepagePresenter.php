<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;


final class HomepagePresenter extends BasePresenter
{
    public function renderDefault(): void
    {
        $this->template->address = $this->addressFacade->getAll();
    }

    public function renderBook(): void
    {
        $this->template->books = $this->bookFacade->getAll();

    }

    public function renderUser(): void
    {
        $this->template->people = $this->userFacade->getAll();
    }

    public function renderAddAddress($id = null): void
    {

    }

    public function renderAddBook($id = null): void
    {

    }

    public function renderAddUser($id = null): void
    {

    }

    /**
     * @param int $id
     * @throws Nette\Application\AbortException
     */
    public function actionDeleteBook(int $id): void
    {
        try {
            $this->bookFacade->delete($id);
            $this->flashMessage('Kniha smazána.', 'alert-success');
            $this->redirect('Homepage:book');
        } catch (Nette\Database\ConnectionException $e) {
            $this->flashMessage('Něco se pokazilo. :(', 'alert-danger');
            $this->redirect('Homepage:book');
        }
    }

    /**
     * @param int $id
     * @throws Nette\Application\AbortException
     */
    public function actionDeleteUser(int $id): void
    {
        try {
            $this->userFacade->delete($id);
            $this->flashMessage('Uživatel smazán.', 'alert-success');
            $this->redirect('Homepage:user');
        } catch (Nette\Database\ConnectionException $e) {
            $this->flashMessage('Něco se pokazilo. :(', 'alert-danger');
            $this->redirect('Homepage:user');
        }
    }

    /**
     * @param int $id
     * @throws Nette\Application\AbortException
     */
    public function actionDeleteAddress(int $id): void
    {
        try {
            $this->addressFacade->delete($id);
            $this->flashMessage('Uživatel smazán.', 'alert-success');
            $this->redirect('Homepage:default');
        } catch (Nette\Database\ConnectionException $e) {
            $this->flashMessage('Něco se pokazilo. :(', 'alert-danger');
            $this->redirect('Homepage:default');
        }
    }

    /**
     * @return Form
     */
    protected function createComponentAddressForm(): Form
    {
        $id = $this->presenter->getParameter('id');
        if ($id !== null) {
            $values = $this->addressFacade->get($id);
            $form = $this->addressFormFactory->create()->setDefaults($values);
        } else {
            $form = $this->addressFormFactory->create();
        }
        $form->onSuccess[] = [$this, 'addressFormSucceeded'];
        return $form;
    }

    /**
     * @return Form
     */
    protected function createComponentBookForm(): Form
    {
        $id = $this->presenter->getParameter('id');
        if ($id !== null) {
            $values = $this->bookFacade->get($id);
            $form = $this->bookFormFactory->create($this->userFacade)->setDefaults($values);
        } else {
            $form = $this->bookFormFactory->create($this->userFacade);
        }
        $form->onSuccess[] = [$this, 'bookFormSucceeded'];
        return $form;
    }

    /**
     * @return Form
     */
    protected function createComponentUserForm(): Form
    {
        $id = $this->presenter->getParameter('id');
        if ($id !== null) {
            $values = $this->userFacade->get($id);
            $form = $this->userFormFactory->create($this->addressFacade)->setDefaults($values);
        } else {
            $form = $this->userFormFactory->create($this->addressFacade);
        }
        $form->onSuccess[] = [$this, 'userFormSucceeded'];
        return $form;
    }


    /**
     * @param Form $form
     * @param Nette\Utils\ArrayHash $values
     * @throws Nette\Application\AbortException
     */
    public function addressFormSucceeded(Form $form, Nette\Utils\ArrayHash $values): void
    {
        (int)$id = $this->presenter->getParameter('id');
        try {
            if (isset($id)) {
                $this->addressFacade->edit($id, $values);
            } else {
                $this->addressFacade->create($values);
            }
            $this->flashMessage('Adresa úspěšně vytvořena/upravena.', 'alert-success');
            $this->redirect('Homepage:default');
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            $form->addError('Někde se stala chyba, profil nebyl upraven.');
        }
    }

    /**
     * @param Form $form
     * @param Nette\Utils\ArrayHash $values
     * @throws Nette\Application\AbortException
     */
    public function bookFormSucceeded(Form $form, Nette\Utils\ArrayHash $values): void
    {
        (int)$id = $this->presenter->getParameter('id');
        try {
            if (isset($id)) {
                if ($values->user_id === 'null') {
                    unset($values->user_id);
                }
                $this->bookFacade->edit($id, $values);
            } else {
                if ($values->user_id === 'null') {
                    unset($values->user_id);
                }
                $this->bookFacade->create($values);
            }
            $this->flashMessage('Kniha úspěšně vytvořena/upravena.', 'alert-success');
            $this->redirect('Homepage:book');
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            $form->addError('Někde se stala chyba, profil nebyl upraven.');
        }
    }

    /**
     * @param Form $form
     * @param Nette\Utils\ArrayHash $values
     * @throws Nette\Application\AbortException
     */
    public function userFormSucceeded(Form $form, Nette\Utils\ArrayHash $values): void
    {
        (int)$id = $this->presenter->getParameter('id');
        try {
            if (isset($id)) {
                $this->userFacade->edit($id, $values);
            } else {
                $this->userFacade->create($values);
            }
            $this->flashMessage('Uživatel úspěšně vytvořen/upraven.', 'alert-success');
            $this->redirect('Homepage:user');
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            $form->addError('Někde se stala chyba, profil nebyl upraven.');
        }
    }




}
