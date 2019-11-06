<?php

/**
 * Controller that handles administrator functions of the Guitar Shop
 * application.
 *
 * @author jam
 * @version 180429
 */
class AdminController extends DefaultController {

    protected $model = null;

    public function __construct() {
        parent::__construct();
    }

    public function loginGET() {
        Page::$title = 'My Guitar Shop - Admin Login';
        require(APP_NON_WEB_BASE_DIR . 'views/adminLogin.php');
    }

    public function formSubmission(){
        //ADD THE  CODE HERE
          //require_once(APP_NON_WEB_BASE_DIR . 'views/validationFunctions.php');
          $sanitized_FirstName = hPOST('firstName');
          $sanitized_LastName = hPOST('lastName');
          $sanitized_email = emailPOST('email');
          $sanitized_phone = hPOST('phone');
          $sanitized_password = hPOST('password');

          /*$password = $_POST['password'];
          echo "Text password: " . $password . "<br />";*/

          //validate password
          if(hasPresence($sanitized_password)) {
            if(strlen($sanitized_password) > 8 ) {
              if(hasFormatMatching($sanitized_password, $regex='/[^A-Za-z0-9]/')){
                $validated_password = $sanitized_password;
          }else {
              echo "Please enter password in proper format. <br />";
              $validated_password = null;
            }
          }
          
          //Validate First Name
          if(hasPresence($sanitized_FirstName)){
            $validated_FirstName = $sanitized_FirstName;
          }else{
            echo "Please enter a valid first name. <br/>";
            $validated_FirstName = null;
          }
          //Validate Last Name
          if(hasPresence($sanitized_LastName)){
            $validated_LastName = $sanitized_LastName;
          }else{
            echo "Please enter a valid last name. <br/>";
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
          hasPresence($validated_email) and hasPresence($validated_phone) and hasPresence($validated_password) ){
            Page::$title = 'CIS 4270 - Form Confirmation';
            require(APP_NON_WEB_BASE_DIR . 'views/success.php');
            $foobar = new AdminDAM;  // correct
            $foobar->addNewUserToDB();
          } else{
            Page::$title = 'CIS 4270 - Contact Us';    
            require(APP_NON_WEB_BASE_DIR . 'views/adminLogin.php');
          }    
        }
      }

    public function listProducts() {
        $vm = ProductsVM::getCategoryInstance();
        Page::$title = 'Product Mgr - ' . $vm->category->name;
        require(APP_NON_WEB_BASE_DIR . 'views/adminProductList.php');
    }

    public function viewProduct() {
        $vm = ProductsVM::getProductInstance();
        Page::$title = 'Product Mgr - ' . $vm->product->name;
        require(APP_NON_WEB_BASE_DIR . 'views/adminProductView.php');
    }

    public function deleteProduct() {
        $vmDelete = ProductsVM::getDeleteInstance();
        $vm = ProductsVM::getCategoryInstance($vmDelete->category->id);
        Page::$title = 'Product Mgr - ' . $vm->category->name;
        require(APP_NON_WEB_BASE_DIR . 'views/adminProductList.php');
    }
    
    public function showAddProduct() {
        Page::$title = 'Product Mgr - Add Product';
        require(APP_NON_WEB_BASE_DIR . 'views/addProduct.php');
    }
    
    public function addEditProduct() {
        $vmAdd = ProductsVM::getAddEditInstance();
        $vm = ProductsVM::getCategoryInstance($vmAdd->category->id);
        Page::$title = 'Product Mgr - ' . $vm->category->name;
        require(APP_NON_WEB_BASE_DIR . 'views/adminProductList.php');
    }
    
    public function showEditProduct() {
        $vm = ProductsVM::getEditProductInstance();
        Page::$title = 'Product Mgr - Edit ' . $vm->product->name;
        require(APP_NON_WEB_BASE_DIR . 'views/editProduct.php');
    }

    private function goToView($vm) {

        // if an error message exists, display the error.
        if ($vm->errorMsg != '') {
            $error = $vm->errorMsg;
            include(NON_WEB_BASE_DIR . 'views/error.php');
        } else {
            Page::$title = 'Admin Console';
            Page::$userName = $_SESSION ['userName'];
            Page::setNavLinks(array('admin profile', 'logout'));
            require(NON_WEB_BASE_DIR . 'views/adminMenu.php');
        }
    }
}
