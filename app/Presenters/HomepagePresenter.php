<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


final class HomepagePresenter extends BasePresenter
{
    public function renderDefault(): void
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/address/read.php");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result);
        $this->template->address = $result;
    }

    public function renderBook(): void
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/book/read.php");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result);
        $this->template->books = $result;

    }

    public function renderUser(): void
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/user/read.php");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result);
        $this->template->people = $result;
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
        $data = array("id" => $id);
        $dataJson = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/book/delete.php");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
        curl_exec($curl);
        curl_close($curl);

        $this->flashMessage('Kniha smazána.', 'alert-success');
        $this->redirect('Homepage:book');
    }

    /**
     * @param int $id
     * @throws Nette\Application\AbortException
     */
    public function actionDeleteUser(int $id): void
    {
        $data = array("id" => $id);
        $dataJson = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/user/delete.php");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
        curl_exec($curl);
        curl_close($curl);

        $this->flashMessage('Uživatel smazán.', 'alert-success');
        $this->redirect('Homepage:user');
    }

    /**
     * @param int $id
     * @throws Nette\Application\AbortException
     */
    public function actionDeleteAddress(int $id): void
    {
        $data = array("id" => $id);
        $dataJson = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/address/delete.php");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
        curl_exec($curl);
        curl_close($curl);

        $this->flashMessage('Uživatel smazán.', 'alert-success');
        $this->redirect('Homepage:default');
    }

    /**
     * @return Form
     */
    protected function createComponentAddressForm(): Form
    {
        $id = $this->presenter->getParameter('id');
        if ($id !== null) {

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/address/read_single.php?id=" . $id);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $result = curl_exec($curl);
            curl_close($curl);
            $values = json_decode($result);

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

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/book/read_single.php?id=" . $id);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $result = curl_exec($curl);
            curl_close($curl);
            $values = json_decode($result);

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

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/user/read_single.php?id=" . $id);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $result = curl_exec($curl);
            curl_close($curl);
            $values = json_decode($result);

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

                $data = array(
                    "id" => $id,
                    "street" => $values->street,
                    "house_number" => $values->house_number,
                    "postal_code" => $values->postal_code,
                    "city" => $values->city,
                    "state" => $values->state,

                );
                $dataJson = json_encode($data);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/address/update.php");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                ));
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
                curl_exec($curl);
                curl_close($curl);

            } else {

                $data = array(
                    "street" => $values->street,
                    "house_number" => $values->house_number,
                    "postal_code" => $values->postal_code,
                    "city" => $values->city,
                    "state" => $values->state,

                );
                $dataJson = json_encode($data);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/address/create.php");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                ));
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
                curl_exec($curl);
                curl_close($curl);

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
                    $values->user_id = "";
                }

                $data = array(
                    "id" => $id,
                    "name" => $values->name,
                    "pages" => $values->pages,
                    "is_borrowed" => $values->is_borrowed,
                    "user_id" => $values->user_id
                );
                $dataJson = json_encode($data);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/book/update.php");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                ));
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
                curl_exec($curl);
                curl_close($curl);

            } else {
                if ($values->user_id === 'null') {
                    unset($values->user_id);
                    $values->user_id = NULL;
                }

                $data = array(
                    "name" => $values->name,
                    "pages" => $values->pages,
                    "is_borrowed" => $values->is_borrowed,
                    "user_id" => $values->user_id
                );
                $dataJson = json_encode($data);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/book/create.php");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                ));
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
                curl_exec($curl);
                curl_close($curl);

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

                $data = array(
                    "id" => $id,
                    "name" => $values->name,
                    "surname" => $values->surname,
                    "birth" => $values->birth,
                    "address_id" => $values->address_id
                );
                $dataJson = json_encode($data);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/user/update.php");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                ));
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
                curl_exec($curl);
                curl_close($curl);

            } else {

                $data = array(
                    "name" => $values->name,
                    "surname" => $values->surname,
                    "birth" => $values->birth,
                    "address_id" => $values->address_id
                );
                $dataJson = json_encode($data);

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "http://localhost/projects/java_project/api/user/create.php");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                ));
                curl_setopt($curl, CURLOPT_POSTFIELDS, $dataJson);
                curl_exec($curl);
                curl_close($curl);

            }
            $this->flashMessage('Uživatel úspěšně vytvořen/upraven.', 'alert-success');
            $this->redirect('Homepage:user');
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            $form->addError('Někde se stala chyba, profil nebyl upraven.');
        }
    }


}
