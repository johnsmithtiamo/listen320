<?php

namespace Storage\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Song\Model\SongCommand;
use Song\Model\SongEvent;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Adapter\AdapterInterface;
use Song\Model\Song;

class PostCountListener extends AbstractListenerAggregate {

    private $adapter;
    private $sql;

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

        if (!$songOld || $songNew->getStorageId() == $songOld->getStorageId()) {
            return;
        }
        // tăng post_count ở chuyên mục mới
        $this->increase($songNew);
        // giảm post_count ở chuyên mục cũ
        $this->decrease($songOld);
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
        $update = $sql->update();
        $update->set(['post_count' => new Expression('post_count + 1')]);
        $update->where(['storage_id' => $song->getStorageId()]);
        $stmt = $sql->prepareStatementForSqlObject($update);
        $stmt->execute();
    }

    /**
     * Giảm số lượng bài hát trong chuyên mục
     * 
     * @param Song $song
     */
    public function decrease(Song $song) {
        $sql = $this->getSql();
        $update = $sql->update();
        $update->set(['post_count' => new Expression('post_count - 1')]);
        $update->where(['storage_id' => $song->getStorageId()]);
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
            $this->sql = new Sql($this->adapter, \Storage\TABLE_NAME);
        }
        return $this->sql;
    }

    /**
     *
     * @param AdapterInterface $adapter
     * @return \Storage\Listener\PostCountListener
     */
    public function setAdapter(AdapterInterface $adapter) {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     *
     * @param Sql $sql
     * @return \Storage\Listener\PostCountListener
     */
    public function setSql(Sql $sql) {
        $this->sql = $sql;
        return $this;
    }

}
