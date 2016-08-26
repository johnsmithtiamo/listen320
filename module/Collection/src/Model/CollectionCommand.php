<?php

namespace Collection\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Driver\ResultInterface;

class CollectionCommand implements CollectionCommandInterface {

    private $db;

    public function __construct(AdapterInterface $db) {
        $this->db = $db;
    }

    public function insertCollection(Collection $collection) {
        $sql = new Sql($this->db, \Collection\TABLE_NAME);
        $insert = $sql->insert();
        $collection_slug = $collection->getCollectionSlug();
        $collection_slug_temp = $collection_slug;
        $i = 1;
        while (true) {
            $select = $sql->select();
            $select->where(['collection_slug' => $collection_slug_temp]);
            $statement = $sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();
            if ($result->count() > 0) {
                $collection_slug_temp = $collection_slug . '-' . $i++;
            } else {
                $collection_slug = $collection_slug_temp;
                break;
            }
        }
        $insert->values([
            'collection_name' => $collection->getCollectionName(),
            'collection_slug' => $collection_slug,
            'collection_description' => $collection->getCollectionDescription(),
        ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during user insert operation'
            );
        }
        $collection->setCollectionId($result->getGeneratedValue());
        return $collection;
    }

    public function deleteCollection(Collection $collection, Seo $seo = null) {
        $sql = new Sql($this->db);
        $delete = $sql->delete(\Collection\TABLE_NAME);
        $delete->where(['collection_id' => $collection->getCollectionId()]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during collection delete operation'
            );
        }
    }

    public function updateCollection(Collection $collection) {
        if (!$collection->getCollectionId()) {
            throw \RuntimeException('Cannot update collection; missing identifier');
        }
        $sql = new Sql($this->db);
        $update = $sql->update(\Collection\TABLE_NAME);

        $update->set([
            'collection_name' => $collection->getCollectionName(),
            'collection_slug' => $collection->getCollectionSlug(),
            'collection_description' => $collection->getCollectionDescription(),
        ]);
        $update->where(['collection_id ' => $collection->getCollectionId()]);


        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during collection update operation'
            );
        }

        return $collection;
    }

}
