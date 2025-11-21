<?php


namespace panels;

use objects\BookLoan;
use objects\BookCopy;

use objects\User;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;

class LoaningPanel extends ModelAdmin {

    private static $menu_title = 'Loaning Dashboard';

    private static $url_segment = 'loaning-dashboard';

    private static $managed_models = [
        BookLoan::class,
        BookCopy::class,
        User::class
    ];
    
    
}


?>