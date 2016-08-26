<?php

namespace CKEditor\Form\View\Helper;

use Zend\Form\View\Helper\FormTextarea;
use Zend\Form\ElementInterface;

class FormCKEditor extends FormTextarea {

    private $ckeditorIsLoaded = false;

    public function render(ElementInterface $element) {
        $name = $element->getName();
        if (empty($name) && $name !== 0) {
            throw new \RuntimeException(sprintf(
                    '%s requires that the element has an assigned name; none discovered', __METHOD__
            ));
        }

        $attributes = $element->getAttributes();
        $attributes['name'] = $name;
        $id = $attributes['id'];
        $content = (string) $element->getValue();
        $escapeHtml = $this->getEscapeHtmlHelper();
        $html = $this->loadCKEditorScript();
        $html .= sprintf('<textarea %s>%s</textarea>', $this->createAttributesString($attributes), $escapeHtml($content));
        $html .=<<<EOD
                <script type="text/javascript">
                    CKEDITOR.replace('{$id}',{
                        language: '{$element->getLanguage()}',
                        uiColor: '{$element->getUiColor()}',
                        height: {$element->getHeight()},
                        toolbarCanCollapse:true
                    });
                </script>
EOD;
        return $html;
    }

    private function loadCKEditorScript() {
        if (!$this->ckeditorIsLoaded) {
            $this->ckeditorIsLoaded = true;
            return '<script type="text/javascript" src="/module/CKEditor/public/ckeditor.js"></script>';
        }
        return '';
    }

}
