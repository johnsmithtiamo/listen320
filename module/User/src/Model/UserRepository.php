<?php

namespace User\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Sql;

class UserRepository implements UserRepositoryInterface {

    /**
     *
     * @var AdapterInterface
     */
    private $db;

    /**
     *
     * @var \Zend\Hydrator\HydratorInterface
     */
    private $hydrator;

    /**
     *
     * @var User
     */
    private $postPrototype;

    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, Post $postPrototype) {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->postPrototype = $postPrototype;
    }

    /**
     *
     * @return User[]
     */
    public function findAllUsers() {
        $sql = new Sql($this->db);
        $select = $sql->select(User\TABLE_NAME);
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);
        return $resultSet;
    }

    /**
     *
     * @param int $user_id
     * @return User
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function findUser($user_id) {
        $sql = new Sql($this->db);
        $select = $sql->select(User\TABLE_NAME);
        $select->where(['user_id = ?' => $user_id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                    'Failed retrieving user with identifier "%s"; unknown database error.', $user_id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->postPrototype);
        $resultSet->initialize($result);
        $user = $resultSet->current();

        if (!$user) {
            throw new InvalidArgumentException(sprintf(
                    'User with identifier "%s" not found.', $user_id
            ));
        }

        return $user;
    }

}
