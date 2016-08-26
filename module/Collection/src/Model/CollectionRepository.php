<?php

namespace Collection\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CollectionRepository implements CollectionRepositoryInterface {

    private $db;
    protected $hydrator;
    private $post_type;

    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, Collection $post_type) {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->post_type = $post_type;
    }

    public function findAllCollections($page = 1, $count = 10, $range = 10) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Collection\TABLE_NAME);
        $dbAdapter = new DbSelect($select, $sql, new HydratingResultSet($this->hydrator, $this->post_type));
        $paginator = new Paginator($dbAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($count);
        $paginator->setPageRange($range);
        return $paginator;
    }

    public function findCollection($collection_id) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Collection\TABLE_NAME);
        $select->where(['collection_id' => $collection_id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                    'Failed retrieving collection with identifier "%s"; unknown database error.', $collection_id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->post_type);
        $resultSet->initialize($result);
        $collectionegory = $resultSet->current();

        if (!$collectionegory) {
            throw new \InvalidArgumentException(sprintf(
                    'Collection with identifier "%s" not found.', $collection_id
            ));
        }

        return $collectionegory;
    }

}
