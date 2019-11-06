<?php

/**
 * Controller that handles home page functions of the Guitar Shop application.
 *
 * @author jam
 * @version 180429
 */
class HomeController extends DefaultController {

    protected $model = null;

    public function __construct() {
        parent::__construct();
    }

	//Form Code
	public function mailingList() {
		//$vm = IDK;
		Page::$title = 'CIS 4270 - Contact Us';
		require(APP_NON_WEB_BASE_DIR . 'views/contactUs.php');
	}
	public function login(){
        if(request_is_post() && request_is_same_domain()) {
	
            if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
                $message = "Sorry, request was not valid.";
            } else {
              // CSRF tests passed--form was created by us recently.
          
                  // retrieve the values submitted via the form
              $username = $_POST['firstName'];
              $password = $_POST['password'];
              
                  if(has_presence($username) && has_presence($password)) {
                      
                      if($user && password_verify($password, $user['hashed_password'])) {
                          // successful login
                              clear_failed_logins($username);
                        after_successful_login();
                        redirect_to('views/success.php');
                      } else {
                        // failed login
                              record_failed_login($username);
                        $message = "Username/password combination not found.";
                      }

                    } else {
                          
                        /*   // Search our fake database to retrieve the user data
                           $sqlsafe_username = sql_prep($username);
                           $user = find_one_in_fake_db('users', 'username', $sqlsafe_username);*/
                  
                      
                  } 
            }
          }
}


    public function listProducts() {
        $vm = ProductsVM::getCategoryInstance();
        Page::$title = 'My Guitar Shop - ' . $vm->category->name;
        require(APP_NON_WEB_BASE_DIR .'views/categoryProductList.php');   //This refers to the method
    }

    public function viewProduct() {
        $vm = ProductsVM::getProductInstance();
        Page::$title = 'My Guitar Shop - ' . $vm->product->name;
        require(APP_NON_WEB_BASE_DIR .'views/productView.php');
    }

    public function getAppraisalStatus() {
        before_every_protected_page();
        $vm = AppraisalResultsVM::getStatusInstance();
        $this->goToView($vm);
    }

    public function verifyDelete() {
        before_every_protected_page();
        Page::$title = 'Verify Delete';
        Page::$userName = $_SESSION ['userName'];
        Page::setNavLinks(array('admin profile', 'logout'));
        require(NON_WEB_BASE_DIR .'views/verifyDelete.php');
    }

    public function deleteAssignments() {
        before_every_protected_page();
        $vm = AppraisalResultsVM::getDeleteInstance() ;
        $this->goToView($vm);
    }

    public function downloadAppraisalResults() {
        before_every_protected_page();
        AppraisalResultsVM::download();
    }

    public function downloadAppraisalReports() {
        before_every_protected_page();
        AppraisalResultsVM::downloadReports();
    }

    public function getProfile() {
        before_every_protected_page();
        $vm = AdminProfileVM::getInstance();
        $this->displayUpdateForm($vm);
    }

    public function updateProfile() {
        $vm = AdminProfileVM::getUpdateInstance();
        if ($vm->errorMsg != '') {
            before_every_protected_page();
            $this->displayUpdateForm($vm);
        } else {
            $this->showMenu();
        }
    }

    public function downloadUpdatedUserProfiles() {
        before_every_protected_page();
        UserProfileUpdatesVM::download();
    }

    public function clearProfilesUpdate() {
        $vm = UserProfileUpdatesVM::getDeleteInstance();
        $this->showMenu($vm->statusMsg);
    }

    public function manageAdmin() {
        before_every_protected_page();
        $vm = AdminProfileVM::getManageInstance();
        $this->protectAdminMgmt($vm);
    }

    public function addAdmin() {
        before_every_protected_page();
        $vm = AdminProfileVM::getAddInstance();
        $this->protectAdminMgmt($vm);
    }

    public function deleteAdmin() {
        before_every_protected_page();
        $vm = AdminProfileVM::getDeleteInstance();
        $this->protectAdminMgmt($vm);
    }

    private function goToView($vm) {

        // if an error message exists, display the error.
        if ($vm->errorMsg != '') {
            $error = $vm->errorMsg;
            include(NON_WEB_BASE_DIR .'views/error.php');
        } else {
            Page::$title = 'Admin Console';
            Page::$userName = $_SESSION ['userName'];
            Page::setNavLinks(array('admin profile', 'logout'));
            require(NON_WEB_BASE_DIR .'views/adminMenu.php');
        }
    }

    private function displayUpdateForm($vm) {
        Page::$title = 'Update Profile';
        Page::$userName = $_SESSION ['userName'];
        Page::setNavLinks(array('admin menu', 'logout', 'contact'));
        include_once(NON_WEB_BASE_DIR .'views/adminProfileUpdate.php');
    }

    private function displayManageAdminForm($vm) {
        Page::$title = 'Manage Administrators';
        Page::$userName = $_SESSION ['userName'];
        Page::setNavLinks(array('admin menu', 'logout', 'contact'));
        include_once(NON_WEB_BASE_DIR .'views/manageAdministrators.php');
    }

    private function protectAdminMgmt($vm) {
        if ($vm->errorMsg === 'Access Denied') {
            $controller = new LoginController();
            $controller->logout();
        } else {
            $this->displayManageAdminForm($vm);
        }
    }
}
