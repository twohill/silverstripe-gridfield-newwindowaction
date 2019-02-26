# silverstripe-gridfield-newwindowaction
Adds a button to the SilverStripe GridField that causes an action to open in a new window.

## How to install
`composer require twohill/silverstripe-gridfield-newwindowaction`

## How to use

Simply replace your normal `SilverStripe\Forms\FormAction` with `Twohill\Forms\NewWindowAction`

## Typical usecase

### MyModelAdmin.php

```php
<?php

namespace My\Admin;

use My\Model;
use My\ModelGridFieldFormItemRequest;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;

class MyModelAdmin extends ModelAdmin
{
    // Usual ModelAdmin stuff here
    private static $managed_models = [Model::class];
    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        /** @var GridField $gridField */
        $gridField = $form->Fields()->first();
        $config = $gridField->getConfig();
        /** @var GridFieldDetailForm $myForm */
        $myForm = $config->getComponentByType(GridFieldDetailForm::class);
        $myForm->setItemRequestClass(ModelGridFieldFormItemRequest::class);

        return $form;
    }

}
```

### ModelGridFieldFormItemRequest.php

```php
<?php

namespace My\Admin;

use My\Model;
use Twohill\Forms\NewWindowAction;
use SilverStripe\Versioned\VersionedGridFieldItemRequest;

class ModelGridFieldFormItemRequest extends VersionedGridFieldItemRequest
{

    private static $allowed_actions = [
        'edit',
        'view',
        'ItemEditForm',
        'generatePDFInvoice',
    ];


    protected function getFormActions()
    {
        $actions = parent::getFormActions();

        $actions->push(NewWindowAction::create('generatePDFInvoice', 'Generate PDF Invoice')
                    ->setUseButtonTag(true)
                    ->addExtraClass('btn-primary font-icon-block-content'));


        return $actions;
    }


    public function generatePDFInvoice() {
            /** @var Model $invoice */
            $invoice = $this->getRecord();
            //$invoice->generatePDFInvoice();
        }
}
```
