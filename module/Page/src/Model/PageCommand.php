<?php

namespace Page\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Driver\ResultInterface;

class PageCommand implements PageCommandInterface, EventManagerAwareInterface {

    private $db;
    protected $events;
    protected $event;

    public function __construct(AdapterInterface $db, EventManagerInterface $events = null) {
        $this->db = $db;
        if ($events) {
            $this->setEventManager($events);
        }
    }

    public function deletePage(Page $page) {
        $events = $this->getEventManager();
        $event = $this->getEvent();
        $event->setPageOld($page);
        $event->setAdapter($this->db);

        // xử lý sự kiện trước khi insert bài hát
        $events->setEventPrototype($event);
        $events->trigger(PageEvent::BEFORE_ZFPAGES_DELETE);

        $sql = new Sql($this->db);
        $delete = $sql->delete(\Page\TABLE_NAME);
        $delete->where(['page_id' => $page->getPageId()]);

        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during page delete operation'
            );
        }
        $events->trigger(PageEvent::AFTER_ZFPAGES_DELETE);
    }

    public function insertPage(Page $page) {
        $events = $this->getEventManager();
        $event = $this->getEvent();
        $event->setPageNew($page);
        $event->setAdapter($this->db);

        // xử lý sự kiện trước khi insert bài hát
        $events->setEventPrototype($event);
        $events->trigger(PageEvent::BEFORE_ZFPAGES_INSERT);

        $sql = new Sql($this->db, \Page\TABLE_NAME);
        $insert = $sql->insert();
        $insert->values([
            'page_name' => $page->getPageName(),
            'page_slug' => $page->getPageSlug(),
            'page_content' => $page->getPageContent(),
            'page_status' => $page->getPageStatus(),
            'page_time' => $page->getPageTime(),
            'title' => $page->getTitle(),
            'meta_description' => $page->getMetaDescription(),
            'meta_keywords' => $page->getMetaKeywords(),
            'meta_robots' => $page->getMetaRobots(),
            'user_id' => $page->getUserId(),
        ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during page insert operation'
            );
        }
        $page->setPageId($result->getGeneratedValue());
        // xử lý sự kiện sau khi insert bài hát
        $events->trigger(PageEvent::AFTER_ZFPAGES_INSERT);
        return $page;
    }

    public function updatePage(Page $pageNew, Page $pageOld = null) {
        if (!$pageNew->getPageId()) {
            throw new \RuntimeException('Cannot update page; missing identifier');
        }
        $events = $this->getEventManager();
        $event = $this->getEvent();
        $event->setPageNew($pageNew);
        $event->setPageOld($pageOld);
        $event->setAdapter($this->db);
        $events->setEventPrototype($event);

        // xử lý sự kiện trước khi update bài hát
        $events->trigger(PageEvent::BEFORE_ZFPAGES_UPDATE);

        $sql = new Sql($this->db);
        $update = $sql->update(\Page\TABLE_NAME);

        $update->set([
            'page_name' => $pageNew->getPageName(),
            'page_slug' => $pageNew->getPageSlug(),
            'page_content' => $pageNew->getPageContent(),
            'page_status' => $pageNew->getPageStatus(),
            'page_time' => $pageNew->getPageTime(),
            'title' => $pageNew->getTitle(),
            'meta_description' => $pageNew->getMetaDescription(),
            'meta_keywords' => $pageNew->getMetaKeywords(),
            'meta_robots' => $pageNew->getMetaRobots(),
            'user_id' => $pageNew->getUserId(),
        ]);
        $update->where(['page_id ' => $pageNew->getPageId()]);


        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        if (!$result instanceof ResultInterface) {
            throw new \RuntimeException(
            'Database error occurred during page update operation'
            );
        }
        // xử lý sự kiện sau khi update bài hát
        $events->trigger(PageEvent::AFTER_ZFPAGES_UPDATE);
        return $pageNew;
    }

    /**
     *
     * @return PageEvent
     */
    public function getEvent() {
        if (!$this->event) {
            $this->event = new PageEvent();
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
