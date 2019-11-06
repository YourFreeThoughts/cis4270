<?php

/**
 * Category model data access and manipulation (DAM) class.
 * This version is vulnerable to SQL injection.
 *
 * @author jam
 * @version 180428
 */
class AdminDAM extends DAM {

    // Database connection is inherited from the parent.
    function __construct() {
        parent::__construct();
    }

    /**
     * Read the Category object from the database with the specified ID
     * @param type $categoryID the ID of the appraiser to be read.
     * @return \Category the resulting Category object - null if category is
     * not in the database.
     */
    public function addNewUserToDB() {
        //global $db;
        $query = "INSERT INTO administrators (emailAddress, password, firstName, lastName) 
        VALUES ('".$_POST["email"]."','".password_hash($_POST["password"], PASSWORD_BCRYPT)."','".$_POST["firstName"]."','".$_POST["lastName"]."')";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
}
public function findUser() {
   /* $query = 'SELECT * FROM administrators
          WHERE firstName = '".$_POST["email"]."'
          AND 
    $statement = $this->db->prepare($query);
    $statement->execute();
    $adminDB = $statement->fetch();
    $statement->closeCursor();
    if ($categoryDB == null) {
        return null;
    } else {
        return new Category($this->mapColsToVars($categoryDB));
    }
}*/
}
}
