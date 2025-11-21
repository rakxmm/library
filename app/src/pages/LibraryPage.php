<?php 

namespace pages;

use objects\Book;
use Page;
use objects\BookAuthor;
use objects\BookCopy;
use objects\BookLoan;
use objects\Genre;
use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Security\Security;

class LibraryPage extends Page 
{

    private static $allowed_children = [
        BookPage::class
    ];

    private static $has_many = [
        'Books' => Book::class,
        'Authors' => BookAuthor::class,
        'Genres' => Genre::class,
        'BookCopies' => BookCopy::class
    ];


    
}

class LibraryPageController extends PageController {

    private static $allowed_actions = [
        'endLoan'
    ];


    public function endLoan(HTTPRequest $req) {
        $copyID = $req->param('ID');
        $userID = $req->param('OtherID');

        $loan = BookLoan::get()->filter([
            'UserID' => $userID,
            'BookCopyID' => $copyID
        ])->first();


        if ($loan) {
            
            $loan->hasExpired = true;
            $loan->write();
        }

        return [
            'BookLoan' => $loan
        ];
        
    }

    

}

?>