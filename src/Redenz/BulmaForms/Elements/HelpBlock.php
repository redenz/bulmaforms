<?php namespace Redenz\BulmaForms\Elements;

use AdamWathan\Form\Elements\Element;

class HelpBlock extends Element
{
    private $message;

    public function __construct($message, $isError)
    {
        $this->message = $message;
        $this->addClass('help');
        if ($isError) {
            $this->addClass('is-danger');
        }
    }

    public function render()
    {
        $html = '<p';
        $html .= $this->renderAttributes();
        $html .= '>';
        $html .= $this->message;
        $html .= '</p>';

        return $html;
    }
}
