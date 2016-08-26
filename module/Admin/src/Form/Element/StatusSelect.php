<?php

namespace Admin\Form\Element;

use Zend\Form\Element\Select;

class StatusSelect extends Select {

    public function getValueOptions() {
        if (!$this->valueOptions) {
            $this->valueOptions = [
                0 => 'Public',
                1 => 'Pending',
            ];
        }
        return $this->valueOptions;
    }

}
