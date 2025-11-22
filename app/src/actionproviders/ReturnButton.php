<?php
namespace actionproviders;

use objects\BookLoan;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ActionRequest;

class GridFieldReturnButton implements GridField_ActionProvider
{
    public function getActions($gridField)
    {
        return ['returnBook'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data)
    {
        if ($actionName === 'returnBook') {
            $record = BookLoan::get()->byID($arguments['RecordID']);
            if ($record && !$record->isReturned()) {
                $record->ReturnedDate = date('Y-m-d');
                $record->Status = 'Returned';
                $record->write();
            }
        }
    }

    public function getColumnAttributes($gridField, $record, $columnName)
    {
        return [];
    }

    public function getColumnContent($gridField, $record, $columnName)
    {
        if ($record->isReturned()) {
            return 'Returned';
        }

        return sprintf(
            '<button class="btn btn-secondary" data-gridfield-action="returnBook" data-record-id="%d">Return</button>',
            $record->ID
        );
    }

    public function getColumnMetadata($gridField, $columnName)
    {
        return ['title' => 'Return'];
    }
}

?>