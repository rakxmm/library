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
        'getAvailableCopies',
        'getBorrowedCopy'
    ];  


    public function getAvailableCopies(HTTPRequest $request) {
        
        $userID = $request->getVar('userID');

        $user  = User::get()->byID($userID);
        if (!$user) {
            return $this->httpError(404, 'User not found!');
        }

        $userCopiesTitles = BookCopy::get()->filter(['UserID' => $userID]
            )->column('BookID');

        if ($userCopiesTitles) {
            $copies = BookCopy::get()->exclude(
                [
                    'BookID' => $userCopiesTitles
                ]
            );

            return json_encode(
                $copies->map('ID', 'Title')->toArray()
            );
        }

        return json_encode(BookCopy::get()->map('ID', 'Title')->toArray());
        
    }

    public function getBorrowedCopy(HTTPRequest $request) {
        $userID = $request->getVar('userID');
        $bookID = $request->getVar('bookID');


        echo BookCopy::get()->filter(['isBorrowed'=>true, 'UserID'=>$userID, 'BookID'=>$bookID])->exists() ? 'true' : 'false';

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
            'BookCopyID' => $copyID,
            'hasExpired' => false
        ])->first();

            

        if ($loan) {
            $loan->end();
        }

        return [
            'BookLoan' => $loan
        ];
        
    }

    

}

?>