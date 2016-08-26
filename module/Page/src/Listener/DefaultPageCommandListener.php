<?php

namespace Page\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Db\Sql\Sql;
use Page\Model\PageEvent;

class DefaultPageCommandListener extends AbstractListenerAggregate {

    public function attach(EventManagerInterface $events, $priority = 1) {
        $this->listeners[] = $events->attach(PageEvent::BEFORE_ZFPAGES_INSERT, [$this, 'filterPageSlug']);
        $this->listeners[] = $events->attach(PageEvent::BEFORE_ZFPAGES_UPDATE, [$this, 'filterPageSlug']);
    }

    public function filterPageSlug(PageEvent $event) {
        $sql = new Sql($event->getAdapter(), \Page\TABLE_NAME);
        $song = $event->getPageNew();
        $songOld = $event->getPageOld();
        if ($songOld && $song->getPageSlug() == $songOld->getPageSlug()) {
            return;
        }
        $page_slug = $song->getPageSlug();
        $page_slug_temp = $page_slug;
        $i = 1;
        $select = $sql->select();
        while (true) {
            $select->where(['page_slug' => $page_slug_temp]);
            $statement = $sql->prepareStatementForSqlObject($select);
            $result = $statement->execute();
            if ($result->count() > 0) {
                $page_slug_temp = $page_slug_temp . '-' . $i++;
            } else {
                $page_slug = $page_slug_temp;
                break;
            }
        }
        $song->setPageSlug($page_slug);
    }

}
