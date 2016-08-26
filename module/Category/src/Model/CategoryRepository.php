<?php

namespace Category\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CategoryRepository implements CategoryRepositoryInterface {

    private $db;
    protected $hydrator;
    private $post_type;

    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, Category $post_type) {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->post_type = $post_type;
    }

    public function findAllCategories($page = 1, $count = 10, $range = 10) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Category\TABLE_NAME);
        $dbAdapter = new DbSelect($select, $sql, new HydratingResultSet($this->hydrator, $this->post_type));
        $paginator = new Paginator($dbAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($count);
        $paginator->setPageRange($range);
        return $paginator;
    }

    public function findCategory($cat_id) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Category\TABLE_NAME);
        $select->where(['category_id' => $cat_id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                    'Failed retrieving category with identifier "%s"; unknown database error.', $cat_id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->post_type);
        $resultSet->initialize($result);
        $category = $resultSet->current();

        if (!$category) {
            throw new \InvalidArgumentException(sprintf(
                    'Category with identifier "%s" not found.', $cat_id
            ));
        }

        return $category;
    }

}
