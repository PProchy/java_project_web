<?php


namespace App\Model;


use Nette\Database\IRow;
use Nette\Database\ResultSet;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Utils\ArrayHash;

class AddressFacade extends BaseFacade
{
    public const TABLE_NAME = 'address';

    /**
     * @param ArrayHash|array $values
     * @return bool|int|ActiveRow
     */
    public function create($values)
    {
        return $this->db->table(self::TABLE_NAME)
            ->insert($values);
    }

    /**
     * @param $id
     */
    public function delete($id): void
    {
        $delete = $this->get($id);
        if ($delete) {
            $delete->delete();
        }
    }

    /**
     * @param int $id
     * @param $values
     */
    public function edit($id, $values): void
    {
        $edit = $this->get($id);
        if ($edit) {
            $edit->update($values);
        }
    }

    /**
     * @return Selection
     */
    public function getAll(): Selection
    {
        return $this->db->table(self::TABLE_NAME);
    }

    /**
     * @return array
     */
    public function getPairAddress(): array
    {
        return $this->db->fetchPairs('
        SELECT id, CONCAT(street," ", house_number, ", ", postal_code, ", ", City) AS name
        FROM address;
        ');

    }


}