<?php

namespace Page\Model;

use Zend\EventManager\Event;
use Zend\Db\Adapter\AdapterInterface;

class PageEvent extends Event {

    // Insert event
    const BEFORE_ZFPAGES_INSERT = 'before.zfpages.insert';
    const AFTER_ZFPAGES_INSERT = 'after.zfpages.insert';
    // Update event
    const BEFORE_ZFPAGES_UPDATE = 'before.zfpages.update';
    const AFTER_ZFPAGES_UPDATE = 'after.zfpages.update';
    // Delete event
    const BEFORE_ZFPAGES_DELETE = 'before.zfpages.delete';
    const AFTER_ZFPAGES_DELETE = 'after.zfpages.delete';

    private $pageNew;
    private $pageOld;
    private $adapter;

    /**
     *
     * @return Page
     */
    public function getPageNew() {
        return $this->pageNew;
    }

    /**
     *
     * @param \Page\Model\Page $pageNew
     * @return \Page\Model\PageEvent
     */
    public function setPageNew(Page $pageNew) {
        $this->pageNew = $pageNew;
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
        return $this->pageOld;
    }

    /**
     *
     * @param \Page\Model\Page $pageOld
     * @return \Page\Model\PageEvent
     */
    public function setPageOld(Page $pageOld) {
        $this->pageOld = $pageOld;
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
