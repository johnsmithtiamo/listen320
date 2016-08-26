<?php

namespace Storage\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Driver\ResultInterface;

class StorageCommand implements StorageCommandInterface {

    private $db;

    public function __construct(AdapterInterface $db) {
        $this->db = $db;
    }

    public function insertStorage(Storage $storage) {
        $sql = new Sql($this->db, \Storage\TABLE_NAME);
        $insert = $sql->insert();

        $insert->values([
            'storage_name' => $storage->getStorageName(),
            'storage_url' => $storage->getStorageUrl(),
        ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during storage insert operation'
            );
        }
        $storage->setStorageId($result->getGeneratedValue());
        return $storage;
    }

    public function deleteStorage(Storage $storage) {
        $sql = new Sql($this->db);
        $delete = $sql->delete(\Storage\TABLE_NAME);
        $delete->where(['storage_id' => $storage->getStorageId()]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during storage delete operation'
            );
        }
    }

    public function updateStorage(Storage $storage) {
        if (!$storage->getStorageId()) {
            throw \RuntimeException('Cannot update storage; missing identifier');
        }
        $sql = new Sql($this->db);
        $update = $sql->update(\Storage\TABLE_NAME);

        $update->set([
            'storage_name' => $storage->getStorageName(),
            'storage_url' => $storage->getStorageUrl(),
        ]);
        $update->where(['storage_id ' => $storage->getStorageId()]);


        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during storage update operation'
            );
        }

        return $storage;
    }

}
