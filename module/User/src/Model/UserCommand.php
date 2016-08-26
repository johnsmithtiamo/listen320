<?php

namespace User\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Sql;

class UserCommand implements UserCommandInterface {

    /**
     *
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    private $db;

    public function __construct(AdapterInterface $db) {
        $this->db = $db;
    }

    public function insertUser(User $user) {
        $sql = new Sql($this->db);
        $insert = $sql->insert(\User\TABLE_NAME);
        $insert->values([
            'user_name' => $user->getUserName(),
            'user_first_name' => $user->getUserFirstName(),
            'user_last_name' => $user->getUserLastName(),
            'user_password' => md5($user->getUserPassword()),
            'user_email' => $user->getUserEmail(),
            'user_role' => $user->getUserRole(),
            'user_time_created' => time(),
        ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during user insert operation'
            );
        }

        return $result->getGeneratedValue();
    }

    public function exists(User $user) {
        $sql = new Sql($this->db);
        $select = $sql->select(\User\TABLE_NAME);
        $select->where->equalTo('user_name', $user->getUserName())->OR->equalTo('user_email', $user->getUserEmail());
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            return false;
        }
        return ($result->count() > 0);
    }

    public function updateUser(User $user) {
        
    }

    public function deleteUser(User $user) {
        
    }

}
