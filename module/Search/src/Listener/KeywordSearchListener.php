<?php

namespace Search\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Song\Model\SongCommand;
use Song\Model\SongEvent;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;

class KeywordSearchListener extends AbstractListenerAggregate {

    private $adapter;
    private $sql;

    public function attach(EventManagerInterface $events, $priority = 1) {
        $sharedManager = $events->getSharedManager();
        $this->listeners[] = $sharedManager->attach(SongCommand::class, SongEvent::AFTER_ZFSONGS_INSERT, [$this, 'OnAfterZfSongsInsert']);
        $this->listeners[] = $sharedManager->attach(SongCommand::class, SongEvent::AFTER_ZFSONGS_UPDATE, [$this, 'OnAfterZfSongsUpdate']);
        $this->listeners[] = $sharedManager->attach(SongCommand::class, SongEvent::AFTER_ZFSONGS_DELETE, [$this, 'OnAfterZfSongsDelete']);
    }

    public function OnAfterZfSongsInsert(SongEvent $e) {
        $sql = $this->getSql();
        $song = $e->getSongNew();
        $insert = $sql->insert();
        $insert->values([
            'song_id' => $song->getSongId(),
            'name' => \str_replace('-', ' ', $song->getSongSlug()),
        ]);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
    }

    public function OnAfterZfSongsUpdate(SongEvent $e) {
        $sql = $this->getSql();
        $song = $e->getSongNew();
        $update = $sql->update();
        $update->set([
            'name' => \str_replace('-', ' ', $song->getSongSlug()),
        ]);
        $update->where(['song_id' => $song->getSongId()]);
        $statement = $sql->prepareStatementForSqlObject($update);
        $statement->execute();
    }

    public function OnAfterZfSongsDelete(SongEvent $e) {
        $sql = $this->getSql();
        $song = $e->getSongOld();
        $delete = $sql->delete();
        $delete->where(['song_id' => $song->getSongId()]);
        $statement = $sql->prepareStatementForSqlObject($delete);
        $statement->execute();
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
            $this->sql = new Sql($this->adapter, \Search\TABLE_NAME);
        }
        return $this->sql;
    }

    /**
     *
     * @param AdapterInterface $adapter
     * @return \Category\Listener\PostCountListener
     */
    public function setAdapter(AdapterInterface $adapter) {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     *
     * @param Sql $sql
     * @return \Category\Listener\PostCountListener
     */
    public function setSql(Sql $sql) {
        $this->sql = $sql;
        return $this;
    }

}
