<?php
// include(__DIR__ . '/../session.php');
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');

class userModel
{
    // all form fields that are being received
    public $id;
    public $email;
    public $password;
    public $status;
    public $requiredFields = ['id', 'email', 'password', 'status'];

    public function __construct()
    {
        //client id recieved by appending into formData object
        $this->id = $_POST['id'];
        $this->email = $_POST['email'];
        $this->password = strtolower($_POST['password']);
        $this->status = $_POST['status'];
    }

    // ********************************************************************************************************************

    public function checkFormFields()
    {
        // loop over all properties of object, if they are not assigned, then set them to "" if string or 0 if number
        foreach ($this as $key => $value) {
            if (!isset($value)) {
                $this->$key = null;
            }
        }
    }

    public function insertToDB()
    {
        global $db;

        // check if all required fields are filled
        foreach ($this->requiredFields as $field) {
            if (!isset($this->$field)) {
                echo "reqFieldError";
                return;
            }
        }

        $this->checkFormFields();

        $sql = "UPDATE users 
        SET 
            email = :email,
            password = :password,
            status = :status
        WHERE
            id = :id;";

        $params = [
            // match parameters to values
            ':id' => $this->id,
            ':email' => $this->email,
            ':password' => $this->password,
            ':status' => $this->status,
        ];

        try {
            $stmt = $db->executePreparedStatement($sql, $params);
        } catch (PDOException $e) {
            echo "error in updating client: " . $e->getMessage();
            // echo "error";
            exit();
        }
        echo "success"; // Image uploaded successfully
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client = new userModel();
    $client->insertToDB();
}
?>