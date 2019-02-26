<?php
namespace Twohill\Forms;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\FormAction;

class NewWindowAction extends FormAction
{
    /**
     * Gets the HTML representing the button
     * @param array $properties
     * @return string
     */
    public function Field($properties = array())
    {
        return sprintf(
            '<a class="btn %s" href="%s" target="_blank">%s</a>',
            $this->extraClass(),
            $this->Link(),
            $this->Title()
        );
    }

    /**
     * Return a link to this field.
     *
     * @param string $action
     *
     * @return string
     */
    public function Link($action = null)
    {
        $link = Controller::join_links($this->form->getController()->Link(), $this->actionName(), $action);
        $this->extend('updateLink', $link, $action);
        return $link;
    }
}
