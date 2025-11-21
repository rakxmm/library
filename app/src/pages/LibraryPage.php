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
        'endLoan',
        'getAvailableCopies'
    ];


    public function getAvailableCopies(HTTPRequest $request) {
        
        $userID = $request->getVar('userID');

        $userCopiesTitles = BookCopy::get()->filter(
            [
                'UserID' => $userID
            ]
        )->getField('BookID');

        

        $copies = BookCopy::get()->exclude(
            [
                'BookID' => $userCopiesTitles
            ]
        );

        return json_encode(
            $copies->map('ID', 'Title')->toArray()
        );
    }
    

    public function endLoan(HTTPRequest $req) {

        $member = Security::getCurrentUser();
        if (!$member) {
            return $this->httpError(403, 'This page is forbidden for you');
        }

        $copyID = $req->getVar('copyID');
        $userID = $req->getVar('userID');

        $loan = BookLoan::get()->filter([
            'UserID' => $userID,
            'BookCopyID' => $copyID
        ])->first();


        if ($loan) {
           $bookcopy = BookCopy::get()->byID($loan->BookCopyID);
           toto nefunguje
            if ($bookcopy) {
                $bookcopy->UserID = 0;
                $bookcopy->write();
        }

            $loan->hasExpired = true;
            $loan->write();
        }

        return [
            'BookLoan' => $loan
        ];
        
    }

    

}

?>