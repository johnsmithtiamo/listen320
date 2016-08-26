<?php

namespace Page\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class PageRepository implements PageRepositoryInterface {

    private $db;
    private $hydrator;
    private $post_type;

    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, Page $post_type = null) {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->post_type = $post_type;
    }

    public function findAllPages($page = 1, $count = 10, $range = 10) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Page\TABLE_NAME);
        $dbAdapter = new DbSelect($select, $sql, new HydratingResultSet($this->hydrator, $this->post_type));
        $paginator = new Paginator($dbAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($count);
        $paginator->setPageRange($range);
        return $paginator;
    }

    public function findPage($page_id) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Page\TABLE_NAME);
        $select->where(['page_id' => $page_id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                    'Failed retrieving page with identifier "%s"; unknown database error.', $page_id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->post_type);
        $resultSet->initialize($result);
        $song = $resultSet->current();

        if (!$song) {
            throw new \InvalidArgumentException(sprintf(
                    'Page with identifier "%s" not found.', $page_id
            ));
        }

        return $song;
    }

}
