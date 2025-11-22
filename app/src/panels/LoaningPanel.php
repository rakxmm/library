<?php


namespace panels;

use objects\BookLoan;
use objects\BookCopy;

use objects\User;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use SilverStripe\View\Requirements;

class LoaningPanel extends ModelAdmin {

    private static $menu_title = 'Loans Dashboard';

    private static $url_segment = 'loans-dashboard';

    private static $managed_models = [
        BookLoan::class,
        User::class
    ];

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        // získa GridField
        $gridField = $form->Fields()->fieldByName($this->sanitiseClassName(BookLoan::class));

        if (!$gridField) {
            return $form;
        }

        // zober si GridFieldConfig
        $config = $gridField->getConfig();

        // odstráň Add New Button
        $config->removeComponentsByType(
            GridFieldAddNewButton::class
        );

        return $form;
    }

        
    
    
}


?>