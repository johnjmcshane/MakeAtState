<?php


class ManageQuestions
{
    private $gTemplate;
    private $dc;
    private $helper;

    private $user_id;
    private $access_level;
    private $groups;

    private static $user;
    private static $nav_array;
    private static $upload_ext;
    private static $upload_path;



    /**
     * Constructor function for manage infrastructure
     * @param Templater $iTempl : emplater object for manage infrastructure class
     */
    public function __construct(Templater &$gTempl)
    {
        $this->iTemplate = $gTempl;
        $this->dc = new DataCalls();
        $this->helper = new PrimeHelper();

        $this->setUser();
        $this->setNavigation();
        $this->setAccessLevel();
        $pTarget = UserData::create('t')->getString();
        $gid = UserData::create('gid')->getInt();
        $success_messages = array();
        $error_messages = array();
        //Call the render function
        $this->renderManageQuestionTemplate();

    }

    /**
     * Sets the user
     */
    private function setUser()
    {
        //lazy loading  user
        if (self::$user == null) {
            self::$user = AuthenticatedUser::getUser();
            $this->user_id = self::$user['user_id'];
        }
    }

    /**
     * Get access level for the user
     */
    private function setAccessLevel()
    {
        $this->access_level = AuthenticatedUser::getUserPermissions();
    }

    /**
     * Sets the navigation for the page
     */
    private function setNavigation()
    {
        if (self::$nav_array == null) {
            self::$nav_array = AuthenticatedUser::getUserNavBar();
        }
    }
     
    /**
     * Render manage workflows template
     */
    private function renderManageQuestionTemplate()
    {
        $this->iTemplate->setTemplate('manage_questions.html');
        $this->iTemplate->setVariables('page_title', "Manage Question");
        $this->iTemplate->setVariables('error_messages', Alerts::getErrorMessages());
        $this->iTemplate->setVariables('success_messages', Alerts::getSuccessMessages());
        $this->iTemplate->setVariables('nav_array', self::$nav_array);
        $this->iTemplate->generate();
    }
}