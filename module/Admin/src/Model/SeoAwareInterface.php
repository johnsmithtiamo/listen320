<?php

namespace Admin\Model;

interface SeoAwareInterface {

    public function getTitle();

    public function setTitle($title);

    public function getMetaDescription();

    public function setMetaDescription($meta_description);

    public function getMetaKeywords();

    public function setMetaKeywords($meta_keyword);

    public function getMetaRobots();

    public function setMetaRobots($meta_robots);
}
