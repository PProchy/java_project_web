<?php


namespace App\Model;


use Nette\Database\Context;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Utils\ArrayHash;

abstract class BaseFacade
{
    public const TABLE_NAME = 'table';

    /** @var Context */
    protected $db;

    /**
     * BaseFacade constructor.
     * @param Context $db
     */
    public function __construct(Context $db)
    {
        $this->db = $db;
    }

    public function get($id): ?ActiveRow
    {
        return $this->db->table(static::TABLE_NAME)->get($id);
    }

    public function findBy(array $conditions = []): Selection
    {

        return $this->db->table(static::TABLE_NAME)
            ->where($conditions);
    }

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
    public function edit(int $id, $values): void
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



}