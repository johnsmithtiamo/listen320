<?php

namespace Song\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Serializer\Adapter\PhpSerialize;

class SongCommand implements SongCommandInterface, EventManagerAwareInterface {

    private $db;
    protected $events;
    protected $event;

    public function __construct(AdapterInterface $db, EventManagerInterface $events = null) {
        $this->db = $db;
        if ($events) {
            $this->setEventManager($events);
        }
    }

    public function deleteSong(Song $song) {
        $events = $this->getEventManager();
        $event = $this->getEvent();
        $event->setSongOld($song);
        $event->setAdapter($this->db);

        // xử lý sự kiện trước khi insert bài hát
        $events->setEventPrototype($event);
        $events->trigger(SongEvent::BEFORE_ZFSONGS_DELETE);

        $sql = new Sql($this->db);
        $delete = $sql->delete(\Song\TABLE_NAME);
        $delete->where(['song_id' => $song->getSongId()]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during song delete operation'
            );
        }
        $events->trigger(SongEvent::AFTER_ZFSONGS_DELETE);
    }

    public function insertSong(Song $song) {
        $events = $this->getEventManager();
        $event = $this->getEvent();
        $event->setSongNew($song);
        $event->setAdapter($this->db);

        // xử lý sự kiện trước khi insert bài hát
        $events->setEventPrototype($event);
        $events->trigger(SongEvent::BEFORE_ZFSONGS_INSERT);

        $sql = new Sql($this->db, \Song\TABLE_NAME);
        $serialize = new PhpSerialize();
        $insert = $sql->insert();
        $insert->values([
            'song_name' => $song->getSongName(),
            'song_slug' => $song->getSongSlug(),
            'song_lyric' => $song->getSongLyric(),
            'song_status' => $song->getSongStatus(),
            'song_time' => $song->getSongTime(),
            'collections' => $serialize->serialize($song->getCollections()),
            'storage_id' => $song->getStorageId(),
            'storage_path' => $song->getStoragePath(),
            'title' => $song->getTitle(),
            'meta_description' => $song->getMetaDescription(),
            'meta_keywords' => $song->getMetaKeywords(),
            'meta_robots' => $song->getMetaRobots(),
            'category_id' => $song->getCategoryId(),
            'user_id' => $song->getUserId(),
        ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during song insert operation'
            );
        }
        $song->setSongId($result->getGeneratedValue());
        // xử lý sự kiện sau khi insert bài hát
        $events->trigger(SongEvent::AFTER_ZFSONGS_INSERT);
        return $song;
    }

    public function updateSong(Song $songNew, Song $songOld = null) {
        if (!$songNew->getSongId()) {
            throw new \RuntimeException('Cannot update song; missing identifier');
        }
        $events = $this->getEventManager();
        $event = $this->getEvent();
        $event->setSongNew($songNew);
        $event->setSongOld($songOld);
        $event->setAdapter($this->db);
        $events->setEventPrototype($event);

        // xử lý sự kiện trước khi update bài hát
        $events->trigger(SongEvent::BEFORE_ZFSONGS_UPDATE);

        $sql = new Sql($this->db);
        $serialize = new PhpSerialize();
        $update = $sql->update(\Song\TABLE_NAME);

        $update->set([
            'song_name' => $songNew->getSongName(),
            'song_slug' => $songNew->getSongSlug(),
            'song_lyric' => $songNew->getSongLyric(),
            'song_status' => $songNew->getSongStatus(),
            'song_time' => $songNew->getSongTime(),
            'collections' => $serialize->serialize($songNew->getCollections()),
            'storage_id' => $songNew->getStorageId(),
            'storage_path' => $songNew->getStoragePath(),
            'title' => $songNew->getTitle(),
            'meta_description' => $songNew->getMetaDescription(),
            'meta_keywords' => $songNew->getMetaKeywords(),
            'meta_robots' => $songNew->getMetaRobots(),
            'category_id' => $songNew->getCategoryId(),
            'user_id' => $songNew->getUserId(),
        ]);
        $update->where(['song_id ' => $songNew->getSongId()]);


        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during song update operation'
            );
        }
        // xử lý sự kiện sau khi update bài hát
        $events->trigger(SongEvent::AFTER_ZFSONGS_UPDATE);
        return $songNew;
    }

    /**
     *
     * @return SongEvent
     */
    public function getEvent() {
        if (!$this->event) {
            $this->event = new SongEvent();
        }
        return $this->event;
    }

    public function setEvent($event) {
        $this->event = $event;
        return $this;
    }

    /**
     *
     * @return EventManager
     */
    public function getEventManager() {
        if (!$this->events) {
            $this->setEventManager(new EventManager);
        }
        return $this->events;
    }

    public function setEventManager(EventManagerInterface $eventManager) {
        $eventManager->setIdentifiers([
            __CLASS__, get_class($this),
        ]);
        $this->events = $eventManager;
        return $this;
    }

}
