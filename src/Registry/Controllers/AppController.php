<?php

namespace Registry\Controllers;

use Registry\Controllers\MemberController;
use Registry\Controllers\BoatController;
use Registry\Views\MenuView;
use Registry\Models\ServiceModel;
use PDO;
use Exception;

class AppController
{
    // TODO: This should probably be in a view
    private $options;

    /**
     * @var MenuView $view
     */
    private $view;

    /**
     * @var ServiceModel $serviceModel
     */
    private $serviceModel;

    /**
     * @var MemberController $memberController
     */
    private $memberController;

    /**
     * @var BoatController $boatController
     */
    private $boatController;

    public function __construct()
    {
        // TODO: Break out to view
        $this->options = array(
            'l' => 'List all members',
            'L' => 'List all members (long)',
            'r' => 'Register new member',
            'e' => 'Edit member',
            'd' => 'Delete member',
            's' => 'Select single member',
            'b' => 'Handle boats',
            'q' => 'Exit application'
        );

        $db = new PDO(DB_CONNECTION_STRING);
        $this->serviceModel = new ServiceModel($db);

        $this->memberController = new MemberController($this->serviceModel);
        $this->boatController = new BoatController($this->serviceModel);

        $this->view = new MenuView($this->options, "-----------\n Main menu \n-----------");
    }

    /**
     * Run the application
     */
    public function run()
    {
        // Show the menu until app exits
        while (true) {
            $this->doAction($this->view->readMenuOption());
        }
    }

    /**
     * Dispatch the correct method based on chosen alternative
     * @param  string $option letter option
     */
    private function doAction($option)
    {
        switch ($option) {
            case 'l':
                $this->memberController->showMemberList();
                break;
            case 'L':
                $this->memberController->showMemberList(true);
                break;
            case 'r':
                $this->memberController->registerMember();
                break;
            case 'e':
                $this->memberController->editMember();
                break;
            case 'd':
                $this->memberController->deleteMember();
                break;
            case 's':
                $this->memberController->selectSingleMember();
                break;
            case 'b':
                $this->boatController->handleBoats();
                break;
            case 'q':
                $this->quitApplication();
                break;
        }
    }

    /**
     * Exits the app
     */
    private function quitApplication()
    {
        print 'Bye bye!'; // TODO: Should be in view
        exit(0);
    }
}
