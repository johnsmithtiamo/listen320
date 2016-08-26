<?php

namespace Admin\Form\Element;

use Zend\Form\Element\Select;

class MetaRobots extends Select {

    public function __construct($name = null, $options = array()) {
        $options['value_options'] = [
            'index,follow' => 'index,follow',
            'index, nofollow' => 'index, nofollow',
            'noindex, follow' => 'noindex, follow',
            'noindex, nofollow' => 'noindex, nofollow'
        ];
        parent::__construct($name, $options);
    }

}
