<?php

namespace CKEditor\Form\Element;

use Traversable;
use Zend\Stdlib\ArrayUtils;
use Zend\Form\Element\Textarea;

class CKEditor extends Textarea {

    private $language = 'vi';
    private $uiColor = '#F7B42C';
    private $height = 300;
    private $width = 300;
    private $toolbarCanCollapse = true;

    public function setOptions($options) {

        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new \InvalidArgumentException(
            'The options parameter must be an array or a Traversable'
            );
        }

        if (isset($options['label'])) {
            $this->setLabel($options['label']);
        }
        if (isset($options['label_attributes'])) {
            $this->setLabelAttributes($options['label_attributes']);
        }

        if (isset($options['label_options'])) {
            $this->setLabelOptions($options['label_options']);
        }
        if (isset($options['language'])) {
            $this->setLanguage($options['language']);
        }
        if (isset($options['uiColor'])) {
            $this->setUiColor($options['uiColor']);
        }

        if (isset($options['height'])) {
            $this->setHeight($options['height']);
        }
        if (isset($options['width'])) {
            $this->setWith($options['width']);
        }
        if (isset($options['toolbarCanCollapse'])) {
            $this->setToolbarCanCollapse($options['toolbarCanCollapse']);
        }
        $this->options = $options;

        return $this;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function getUiColor() {
        return $this->uiColor;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getToolbarCanCollapse() {
        return $this->toolbarCanCollapse;
    }

    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }

    public function setUiColor($uiColor) {
        $this->uiColor = $uiColor;
        return $this;
    }

    public function setHeight($height) {
        $this->height = $height;
        return $this;
    }

    public function setWidth($width) {
        $this->width = $width;
        return $this;
    }

    public function setToolbarCanCollapse($toolbarCanCollapse) {
        $this->toolbarCanCollapse = $toolbarCanCollapse;
        return $this;
    }

}
