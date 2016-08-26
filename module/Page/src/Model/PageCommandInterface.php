<?php

namespace Page\Model;

interface PageCommandInterface {

    public function insertPage(Page $song);

    public function updatePage(Page $songNew, Page $songOld = null);

    public function deletePage(Page $song);
}
