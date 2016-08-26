<?php

namespace Storage\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class StorageRepository implements StorageRepositoryInterface {

    private $db;
    protected $hydrator;
    private $post_type;

    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, Storage $post_type) {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->post_type = $post_type;
    }

    public function findAllStorages($page = 1, $count = 10, $range = 10) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Storage\TABLE_NAME);
        $dbAdapter = new DbSelect($select, $sql, new HydratingResultSet($this->hydrator, $this->post_type));
        $paginator = new Paginator($dbAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($count);
        $paginator->setPageRange($range);
        return $paginator;
    }

    public function findStorage($storage_id) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Storage\TABLE_NAME);
        $select->where(['storage_id' => $storage_id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                    'Failed retrieving category with identifier "%s"; unknown database error.', $storage_id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->post_type);
        $resultSet->initialize($result);
        $storage = $resultSet->current();

        if (!$storage) {
            throw new \InvalidArgumentException(sprintf(
                    'Storage with identifier "%s" not found.', $storage_id
            ));
        }

        return $storage;
    }

}
