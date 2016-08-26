<?php

namespace Song\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Db\Sql\Sql;
use Song\Model\SongEvent;

class DefaultSongCommandListener extends AbstractListenerAggregate {

    public function attach(EventManagerInterface $events, $priority = 1) {
        $this->listeners[] = $events->attach(SongEvent::BEFORE_ZFSONGS_INSERT, [$this, 'filterSongSlug']);
        $this->listeners[] = $events->attach(SongEvent::BEFORE_ZFSONGS_UPDATE, [$this, 'filterSongSlug']);
    }

    public function filterSongSlug(SongEvent $event) {
        $sql = new Sql($event->getAdapter(), \Song\TABLE_NAME);
        $song = $event->getSongNew();
        $songOld = $event->getSongOld();
        if ($songOld && $song->getSongSlug() == $songOld->getSongSlug()) {
            return;
        }
        $song_slug = $song->getSongSlug();
        $song_slug_temp = $song_slug;
        $i = 1;
        $select = $sql->select();
        while (true) {
            $select->where(['song_slug' => $song_slug_temp]);
            $statement = $sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();
            if ($result->count() > 0) {
                $song_slug_temp = $song_slug_temp . '-' . $i++;
            } else {
                $song_slug = $song_slug_temp;
                break;
            }
        }
        $song->setSongSlug($song_slug);
    }

}
