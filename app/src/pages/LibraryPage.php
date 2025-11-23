<?php 

namespace pages;

use objects\Book;
use Page;
use objects\BookAuthor;
use objects\BookCopy;
use objects\BookLoan;
use objects\Genre;
use objects\User;
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
        'endLoan',
        'getBorrowedCopy'
    ];  


    public function endLoan(HTTPRequest $request) {
        $userID = $request->getVar('userID');
        $copyID = $request->getVar('copyID');
        
        $loan = BookLoan::get()->filter([
            'UserID' => $userID,
            'BookCopyID' => $copyID,
            'hasExpired' => false
        ])->first();

        
        if ($loan) {
            
            $loan->end();
        }

        
    }

    

    public function getBorrowedCopy(HTTPRequest $request) {
        $userID = $request->getVar('userID');
        $bookID = $request->getVar('bookID');


        echo json_encode(BookCopy::get()->filter([
            'UserID' => $userID
        ])->toArray());

    }


    

}

?>