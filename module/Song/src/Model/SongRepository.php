<?php

namespace Song\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class SongRepository implements SongRepositoryInterface {

    private $db;
    private $hydrator;
    private $post_type;

    public function __construct(AdapterInterface $db, HydratorInterface $hydrator, Song $post_type = null) {
        $this->db = $db;
        $this->hydrator = $hydrator;
        $this->post_type = $post_type;
    }

    public function findAllSongs($page = 1, $count = 10, $range = 10) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Song\TABLE_NAME);
        $dbAdapter = new DbSelect($select, $sql, new HydratingResultSet($this->hydrator, $this->post_type));
        $paginator = new Paginator($dbAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($count);
        $paginator->setPageRange($range);
        return $paginator;
    }

    public function findWithSong(Song $song, $page = 1, $count = 10, $range = 10) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Song\TABLE_NAME);
        $cat_id = $song->getCategoryId();
        if ($cat_id) {
            $select->where(['category_id' => $cat_id]);
        }
        $status = $song->getSongStatus();
        if ($status) {
            $select->where(['song_status' => $status]);
        }
        $name = \str_replace('-', ' ', $song->getSongSlug());
        if ($name) {
            $select2 = new Select(\Search\TABLE_NAME);
            $select2->columns([
                'song_id',
                // xác định vị trí xuất hiện từ khóa
                'p' => new Expression('LOCATE(? ,name)', [$name]),
                // xác định độ ưu tiên của từ khóa
                'r' => new Expression('MATCH(name) against(? IN BOOLEAN MODE) + if(name like ?,1,0)', [
                    '>"' . $name . '" >' . \str_replace(' ', ' >', $name),
                    '%' . \str_replace(' ', '%', $name) . '%'
                        ]
                )
            ]);
            // mệnh đề where để tìm kiếm fts
            $select2->where->expression('MATCH(name) AGAINST(? IN BOOLEAN MODE)', [$name]);
        }
        $select->join(['k' => $select2], 'k.song_id = ' . \Song\TABLE_NAME . '.song_id', []);
        // sắp xếp kết quả theo độ ưu tiên và vị trí xuất hiện
        $select->order(['k.r' => 'DESC', 'k.p' => 'ASC']);

        $dbAdapter = new DbSelect($select, $sql, new HydratingResultSet($this->hydrator, $this->post_type));
        $paginator = new Paginator($dbAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($count);
        $paginator->setPageRange($range);
        return $paginator;
    }

    public function findSong($song_id) {
        $sql = new Sql($this->db);
        $select = $sql->select(\Song\TABLE_NAME);
        $select->where(['song_id' => $song_id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface || !$result->isQueryResult()) {
            throw new \RuntimeException(sprintf(
                    'Failed retrieving song with identifier "%s"; unknown database error.', $song_id
            ));
        }

        $resultSet = new HydratingResultSet($this->hydrator, $this->post_type);
        $resultSet->initialize($result);
        $song = $resultSet->current();

        if (!$song) {
            throw new \InvalidArgumentException(sprintf(
                    'Song with identifier "%s" not found.', $song_id
            ));
        }

        return $song;
    }

}
