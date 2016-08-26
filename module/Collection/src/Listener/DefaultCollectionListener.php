<?php

namespace Collection\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Song\Model\SongCommand;
use Song\Model\SongEvent;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Adapter\AdapterInterface;
use Song\Model\Song;

class DefaultCollectionListener extends AbstractListenerAggregate {

    private $adapter;
    private $sql;

    const TABLE_NAME = 'zf_collection_song';

    public function attach(EventManagerInterface $events, $priority = 1) {
        $sharedManager = $events->getSharedManager();
        $this->listeners[] = $sharedManager->attach(SongCommand::class, SongEvent::AFTER_ZFSONGS_INSERT, [$this, 'OnAfterZfSongsInsert']);
        $this->listeners[] = $sharedManager->attach(SongCommand::class, SongEvent::AFTER_ZFSONGS_UPDATE, [$this, 'OnAfterZfSongsUpdate']);
        $this->listeners[] = $sharedManager->attach(SongCommand::class, SongEvent::AFTER_ZFSONGS_DELETE, [$this, 'OnAfterZfSongsDelete']);
    }

    public function OnAfterZfSongsInsert(SongEvent $e) {
        // Tự động tăng post_count khi thêm mới một bài hát
        $this->increase($e->getSongNew());
    }

    public function OnAfterZfSongsUpdate(SongEvent $e) {
        $songNew = $e->getSongNew();
        $songOld = $e->getSongOld();
        $collectionsNew = $songNew->getCollections();
        $collectionsOld = $songOld->getCollections();
        if (!$songOld || $collectionsNew == $collectionsOld) {
            return;
        }
        $insert = array_diff($collectionsNew, $collectionsOld);
        $delete = array_diff($collectionsOld, $collectionsNew);
        $song = new Song();
        $song->setSongId($songNew->getSongId());

        // tăng liên kết bảng và tăng post_count
        if (count($insert) > 0) {
            $song->setCollections($insert);
            $this->increase($song);
        }
        // giảm liên kết bảng và giảm post_count
        if (count($delete) > 0) {
            $song->setCollections($delete);
            $this->decrease($song);
        }
    }

    public function OnAfterZfSongsDelete(SongEvent $e) {
        // Tự động giamr post_count khi xóa một bài hát
        $this->decrease($e->getSongOld());
    }

    /**
     * Tăng số lượng bài hát trong chuyên mục
     *
     * @param Song $song
     */
    public function increase(Song $song) {
        $sql = $this->getSql();
        $song_id = $song->getSongId();
        $collections = $song->getCollections();

        // tạo liên kết bảng
        $insert = $sql->insert(self::TABLE_NAME);
        foreach ($collections as $collection_id) {
            // tạo liên kết bảng
            $insert->values(['collection_id' => $collection_id, 'song_id' => $song_id]);
            $stmt1 = $sql->prepareStatementForSqlObject($insert);
            $stmt1->execute();
            sleep(1);
        }
        // cập nhật post_count
        $update = $sql->update(\Collection\TABLE_NAME);
        $update->set(['post_count' => new Expression('post_count + 1')]);
        $update->where(['collection_id' => $collections]);
        $stmt2 = $sql->prepareStatementForSqlObject($update);
        $stmt2->execute();
    }

    /**
     * Giảm số lượng bài hát trong chuyên mục
     * 
     * @param Song $song
     */
    public function decrease(Song $song) {
        $sql = $this->getSql();
        $song_id = $song->getSongId();
        $collections = $song->getCollections();

        // xóa liên kết bảng
        $delete = $sql->delete(self::TABLE_NAME);
        $delete->where(['collection_id' => $collections, 'song_id' => $song_id]);
        $stmt1 = $sql->prepareStatementForSqlObject($delete);
        $stmt1->execute();
        // cập nhật post_count
        $update = $sql->update(\Collection\TABLE_NAME);
        $update->set(['post_count' => new Expression('post_count - 1')]);
        $update->where(['collection_id' => $collections]);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $stmt->execute();
    }

    /**
     *
     * @return AdapterInterface
     */
    public function getAdapter() {
        return $this->adapter;
    }

    /**
     *
     * @return Sql
     */
    public function getSql() {
        if (!$this->sql) {
            $this->sql = new Sql($this->adapter);
        }
        return $this->sql;
    }

    /**
     *
     * @param AdapterInterface $adapter
     * @return \Collection\Listener\PostCountListener
     */
    public function setAdapter(AdapterInterface $adapter) {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     *
     * @param Sql $sql
     * @return \Collection\Listener\PostCountListener
     */
    public function setSql(Sql $sql) {
        $this->sql = $sql;
        return $this;
    }

}
