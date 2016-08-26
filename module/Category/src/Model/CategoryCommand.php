<?php

namespace Category\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Driver\ResultInterface;

class CategoryCommand implements CategoryCommandInterface {

    private $db;

    public function __construct(AdapterInterface $db) {
        $this->db = $db;
    }

    public function insertCategory(Category $cat) {
        $sql = new Sql($this->db, \Category\TABLE_NAME);
        $insert = $sql->insert();
        $category_slug = $cat->getCategorySlug();
        $category_slug_temp = $category_slug;
        $i = 1;
        while (true) {
            $select = $sql->select();
            $select->where(['category_slug' => $category_slug_temp]);
            $statement = $sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();
            if ($result->count() > 0) {
                $category_slug_temp = $category_slug . '-' . $i++;
            } else {
                $category_slug = $category_slug_temp;
                break;
            }
        }
        $insert->values([
            'category_name' => $cat->getCategoryName(),
            'category_slug' => $category_slug,
            'category_description' => $cat->getCategoryDescription(),
        ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during user insert operation'
            );
        }
        $cat->setCategoryId($result->getGeneratedValue());
        return $cat;
    }

    public function deleteCategory(Category $cat, Seo $seo = null) {
        $sql = new Sql($this->db);
        $delete = $sql->delete(\Category\TABLE_NAME);
        $delete->where(['category_id' => $cat->getCategoryId()]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during category delete operation'
            );
        }
    }

    public function updateCategory(Category $cat) {
        if (!$cat->getCategoryId()) {
            throw \RuntimeException('Cannot update category; missing identifier');
        }
        $sql = new Sql($this->db);
        $update = $sql->update(\Category\TABLE_NAME);

        $update->set([
            'category_name' => $cat->getCategoryName(),
            'category_slug' => $cat->getCategorySlug(),
            'category_description' => $cat->getCategoryDescription(),
            'category_order' => $cat->getCategoryOrder(),
            'category_visible' => $cat->getCategoryVisible(),
            'title' => $cat->getTitle(),
            'meta_description' => $cat->getMetaDescription(),
            'meta_keywords' => $cat->getMetaKeywords(),
            'meta_robots' => $cat->getMetaRobots()
        ]);
        $update->where(['category_id ' => $cat->getCategoryId()]);


        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during category update operation'
            );
        }

        return $cat;
    }

}
