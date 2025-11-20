<?php


namespace panels;

use objects\BookCopy;
use objects\Loan;
use objects\User;
use SilverStripe\Admin\ModelAdmin;

class LoaningPanel extends ModelAdmin {

    private static $menu_title = 'Loaning Dashboard';

    private static $url_segment = 'loaning-dashboard';

    private static $managed_models = [
        Loan::class,
        BookCopy::class,
        User::class
    ];

    


}


?>