<?php

namespace Song\Model;

use Zend\EventManager\Event;
use Zend\Db\Adapter\AdapterInterface;

class SongEvent extends Event {

    // Insert event
    const BEFORE_ZFSONGS_INSERT = 'before.zfsongs.insert';
    const AFTER_ZFSONGS_INSERT = 'after.zfsongs.insert';
    // Update event
    const BEFORE_ZFSONGS_UPDATE = 'before.zfsongs.update';
    const AFTER_ZFSONGS_UPDATE = 'after.zfsongs.update';
    // Delete event
    const BEFORE_ZFSONGS_DELETE = 'before.zfsongs.delete';
    const AFTER_ZFSONGS_DELETE = 'after.zfsongs.delete';

    private $songNew;
    private $songOld;
    private $adapter;

    /**
     *
     * @return Song
     */
    public function getSongNew() {
        return $this->songNew;
    }

    /**
     *
     * @param \Song\Model\Song $songNew
     * @return \Song\Model\SongEvent
     */
    public function setSongNew(Song $songNew) {
        $this->songNew = $songNew;
        return $this;
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
     * @return Song
     */
    public function getSongOld() {
        return $this->songOld;
    }

    /**
     *
     * @param \Song\Model\Song $songOld
     * @return \Song\Model\SongEvent
     */
    public function setSongOld(Song $songOld) {
        $this->songOld = $songOld;
        return $this;
    }

    /**
     *
     * @param AdapterInterface $adapter
     * @return \Song\Model\SongEvent
     */
    public function setAdapter(AdapterInterface $adapter) {
        $this->adapter = $adapter;
        return $this;
    }

}
