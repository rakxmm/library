<?php


namespace panels;

use Exception;
use objects\BookLoan;

use objects\User;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Control\Controller;

class LoanPanel extends ModelAdmin {

    private static $menu_title = 'Loans Dashboard';

    private static $url_segment = 'loans-dashboard';

    private static $managed_models = [
        BookLoan::class,
        User::class
    ];

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        $gridField = $form->Fields()->dataFieldByName($this->sanitiseClassName(BookLoan::class));

        if (!$gridField) {
            return $form;
        }

        $config = $gridField->getConfig();

        $config->removeComponentsByType(
            GridFieldAddNewButton::class
        );

        $gridField->getConfig()->addComponent(new LoanPanelReturnAction());


        return $form;
    }

        
    
    
}


class LoanPanelReturnAction implements GridField_ActionProvider, GridField_ColumnProvider {

    public function getActions($gridField)
    {
        return ['endLoan'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data)
    {
        if ($actionName != 'endloan') {
            return;
        }

            $loan = BookLoan::get()->byID($arguments['RecordID']);
            if (!$loan) {
                Controller::curr()->getResponse()->setStatusCode(404, 'Loan not found!');
                return;
            }
            
            $loan->end();

            Controller::curr()->getResponse()->setStatusCode(200, 'Loan ended successfully!');
        
    }

   
    


    public function augmentColumns($gridField, &$columns)
    {
        if (!in_array('Actions', $columns)) {
            $columns[] = 'Actions';
        }
    }

    public function getColumnContent($gridField, $record, $columnName)
    {
        if ($columnName == 'Actions') {

            if (!$record->canEnd()) return;

            $returnField = GridField_FormAction::create(
                $gridField,
                'EndLoanAction'.$record->ID,
                'End Loan',
                'endLoan',
                ['RecordID'=>$record->ID]
            );
            $returnField->addExtraClass('btn btn-outline-danger btn-hide-outline font-icon-cancel');
            
            return $returnField->Field();    
        }
    }   

    public function getColumnAttributes($gridField, $record, $columnName)
    {
        return ['class' => 'grid-field__col-compact'];
    }

    public function getColumnMetadata($gridField, $columnName)
    {
        if ($columnName == 'Actions') {
            return ['title' => 'Actions'];
        }
    }

    public function getColumnsHandled($gridField)
    {
        return ['Actions'];
    }
}

?>