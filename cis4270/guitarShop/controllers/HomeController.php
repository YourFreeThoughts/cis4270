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

	// Form Code
	public function mailingList() {
		//$vm = IDK;
		Page::$title = 'CIS 4270 - Contact Us';
		require(APP_NON_WEB_BASE_DIR . 'views/contactUs.php');
	}
	public function formSubmission(){
  //ADD CODE HERE
    //require_once(APP_NON_WEB_BASE_DIR . 'views/validationFunctions.php');
    $sanitized_FirstName = hPOST('firstName');
    $sanitized_LastName = hPOST('lastName');
    $sanitized_email = emailPOST('email');
    $sanitized_phone = hPOST('phone');

    //Validate First Name
    if(hasPresence($sanitized_FirstName)){
      $validated_FirstName = $sanitized_FirstName;
    }else{
      echo "Please enter a valid First Name. <br/>";
      $validated_FirstName = null;
    }
    //Validate Last Name
    if(hasPresence($sanitized_LastName)){
      $validated_LastName = $sanitized_LastName;
    }else{
      echo "Please enter a valid Last Name. <br/>";
      $validated_LastName = null;
    }
    //Validate Email
    if(hasPresence($sanitized_email)){
      $validated_email = $sanitized_email;
    }else{
      echo "Please enter a valid Email Address. <br/>";
      $validated_email = null;
    }
    //Validate Phone Number
    if(hasPresence($sanitized_phone)){
    	if(hasFormatMatching($sanitized_phone, $regex='/^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/')){
    		  $validated_phone = $sanitized_phone;
    	}/* else if(hasFormatMatching($sanitized_phone, $regex='/\d{5}/')){
          $validated_phone = $sanitized_phone;
      } */else{
        echo "Please enter a valid Phone Number <br/>";
        $validated_phone = null;
      }
    }else{
    		  echo "Please enter a valid Phone Number <br/>";
          $validated_phone = null;
    }

    if(hasPresence($validated_FirstName) and hasPresence($validated_LastName) and
    hasPresence($validated_email) and hasPresence($validated_phone) ){
      Page::$title = 'CIS 4270 - Form Confirmation';
      require(APP_NON_WEB_BASE_DIR . 'views/success.php');
    } else{
      Page::$title = 'CIS 4270 - Admin Login';

      require(APP_NON_WEB_BASE_DIR . 'views/adminLogin.php');
    }

	}
  //xss prevention
  // Sanitize for HTML output
  function h($string) {
  	return htmlspecialchars($string);
  }

  // Sanitize for JavaScript output
  function j($string) {
  	return json_encode($string);
  }

  // Sanitize for use in a URL
  function u($string) {
  	return urlencode($string);
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
