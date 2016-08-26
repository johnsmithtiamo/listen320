<?php

namespace Page\Model;

use Zend\EventManager\Event;
use Zend\Db\Adapter\AdapterInterface;

class PageEvent extends Event {

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
     * @return Page
     */
    public function getPageNew() {
        return $this->songNew;
    }

    /**
     *
     * @param \Page\Model\Page $songNew
     * @return \Page\Model\PageEvent
     */
    public function setPageNew(Page $songNew) {
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
     * @return Page
     */
    public function getPageOld() {
        return $this->songOld;
    }

    /**
     *
     * @param \Page\Model\Page $songOld
     * @return \Page\Model\PageEvent
     */
    public function setPageOld(Page $songOld) {
        $this->songOld = $songOld;
        return $this;
    }

    /**
     *
     * @param AdapterInterface $adapter
     * @return \Page\Model\PageEvent
     */
    public function setAdapter(AdapterInterface $adapter) {
        $this->adapter = $adapter;
        return $this;
    }

}
