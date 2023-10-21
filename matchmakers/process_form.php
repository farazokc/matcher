<?php
include(__DIR__ . '/../session.php');

class clientModel
{
    public $client_id;
    public $matchmaker_id;
    public $gender;
    public $first_name;
    public $last_name;
    public $dob;
    public $education;
    public $occupation;
    public $address;
    public $contact;
    public $location;
    public $description;

    public $image;
    public $image_name;
    public $img_tmp_name;
    public $imageFileType;
    public $targetDir;
    public $targetFile;
    public $uploadOk;

    public function __construct()
    {
        // client stuff
        $this->client_id = getIncrementId();
        $this->matchmaker_id = $_SESSION['matchmakers_id'];
        $this->gender = $_POST['gender'];
        $this->first_name = strtolower($_POST['first_name']);
        $this->last_name = strtolower($_POST['last_name']);
        $this->dob = date('Y-m-d', strtotime($_POST['DOB']));
        $this->education = $_POST['education'];
        $this->occupation = $_POST['occupation'];
        $this->address = $_POST['address'];
        $this->contact = $_POST['contact'];
        $this->location = $_POST['address'];
        $this->description = $_POST['description'];

        // image stuff
        $this->image = $_FILES['image'];
        $this->image_name = $_FILES['image']['name'];
        $this->img_tmp_name = $_FILES['image']['tmp_name'];
        $this->targetDir = 'images' . DIRECTORY_SEPARATOR;
        $this->uploadOk = 1;
    }

    // ********************************************************************************************************************
    // Client Operations

    function checkForExistingRecords()
    {
        global $db;

        $sql = 'SELECT * FROM clients WHERE matchmaker_id = :matchmaker_id AND first_name = :first_name AND last_name = :last_name AND dob = :dob';
        $params = [
            ':matchmaker_id' => $this->matchmaker_id,
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':dob' => $this->dob,
        ];

        $stmt = $db->executePreparedStatement($sql, $params);
        $row = $db->fetchRow($stmt);

        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    // ********************************************************************************************************************
    // File Operations

    public function setImageFileType()
    {
        $exp = explode(".", $this->image_name);
        $this->imageFileType = strtolower(end($exp));
        return;
    }

    public function setTargetFile()
    {
        $this->targetFile = $this->targetDir . $this->client_id . '.' . $this->imageFileType;
        return;
    }

    public function checkImageReal()
    {
        // Check if image file is a actual image or fake image
        // echo "img_tmp_name" . $this->img_tmp_name;
        $check = getimagesize($this->img_tmp_name);
        if ($check) {
            return 1;
        }
        return 0;
    }

    public function checkUnderFileSize()
    {
        if ($this->image['size'] > 5242880) {
            return 0;
        }
        return 1;
    }

    public function checkFileExtAllowed()
    {
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($this->imageFileType, $allowed)) {
            return 1;
        }
        return 0;
    }

    public function insertToDB()
    {
        global $db;

        if (move_uploaded_file($this->img_tmp_name, __DIR__ . "/../" . ($this->targetFile))) {
            $sql = "INSERT INTO clients (matchmaker_id, gender, first_name, last_name, dob, photo_path, education, occupation, contact, location, description) VALUES (:matchmaker_id, :gender, :first_name, :last_name, :dob, :photo_path, :education, :occupation, :contact, :location, :description)";

            $params = [
                // match parameters to values
                ':matchmaker_id' => $this->matchmaker_id,
                ':gender' => $this->gender,
                ':first_name' => $this->first_name,
                ':last_name' => $this->last_name,
                ':dob' => $this->dob,
                ':photo_path' => $this->targetFile,
                ':education' => $this->education,
                ':occupation' => $this->address,
                ':contact' => $this->contact,
                ':location' => $this->address,
                ':description' => $this->description
            ];

            $stmt = $db->executePreparedStatement($sql, $params);
            echo "success"; // Image uploaded successfully
        } else {
            echo "fileError"; // Error uploading file
        }
    }

}


// function checkUnderFileSize($fileSize)
// {
//     if ($fileSize > 5242880) {
//         return false;
//     }
//     return true;
// }

// function checkFileExtAllowed($fileExt)
// {
//     $allowed = array('jpg', 'jpeg', 'png', 'gif');
//     if (in_array($fileExt, $allowed)) {
//         return true;
//     }
//     return false;
// }

function getIncrementId()
{
    global $db;

    $sql = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :tbl';
    $params = [
        ':db' => 'matrimonial',
        ':tbl' => 'clients',
    ];

    $stmt = $db->executePreparedStatement($sql, $params);
    $row = $db->fetchRow($stmt);

    if ($row && $row['AUTO_INCREMENT'] != null) {
        return $row['AUTO_INCREMENT'];
    } else {
        return 1;
    }
}

// function checkForExistingRecords($matchmaker_id, $first_name, $last_name, $DOB)
// {
//     global $db;

//     $sql = 'SELECT * FROM clients WHERE matchmaker_id = :matchmaker_id AND first_name = :first_name AND last_name = :last_name AND dob = :dob';
//     $params = [
//         ':matchmaker_id' => $matchmaker_id,
//         ':first_name' => $first_name,
//         ':last_name' => $last_name,
//         ':dob' => $DOB,
//     ];

//     $stmt = $db->executePreparedStatement($sql, $params);
//     $row = $db->fetchRow($stmt);

//     if ($row) {
//         return true;
//     } else {
//         return false;
//     }
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $client = new clientModel();

    //check for existing records
    if ($client->checkForExistingRecords()) {
        echo "existingRecord";
        return;
    }

    // set image file type
    $client->setImageFileType();

    // set target file
    $client->setTargetFile();

    // check if image is real
    if (!($client->checkImageReal())) {
        echo "fakeImgError";
        $client->uploadOk = 0;
        return;
    }

    // check file size under 5MB
    if (!($client->checkUnderFileSize())) {
        echo "sizeError";
        $client->uploadOk = 0;
        return;
    }

    // check if file ext is allowed
    if (!($client->checkFileExtAllowed())) {
        echo "extError";
        $client->uploadOk = 0;
        return;
    }

    // check if file exists
    if (file_exists($client->targetFile)) {
        echo "File already exists";
        return;
    }

    // insert to db
    $client->insertToDB();


    // get matchmaker id from session
    // $matchmaker_id = $_SESSION['matchmakers_id'];

    // Get and transform data from the request
    // *******************************************************
    // $first_name = strtolower($_POST['first_name']);
    // $last_name = strtolower($_POST['last_name']);

    // $plainDate = $_POST['DOB'];
    // $DOB = date('Y-m-d', strtotime($plainDate));

    // $gender = $_POST['gender'];
    // $education = $_POST['education'];
    // $address = $_POST['address'];
    // $contact = $_POST['contact'];
    // $description = $_POST['description'];
    // *******************************************************

    //get the last client id from the table

    // $client_id = getIncrementId();


    // set target file path
    // $image_name = $_FILES['image']['name'];
    // $exp = explode(".", $image_name);
    // $imageFileType = end($exp);

    // $targetDir = "images/";
    // $targetFile = $targetDir . $client_id . '.' . $imageFileType; // set file name from client id

    // $uploadOk = 1;

    // Check if image file is a actual image or fake image
    // $check = getimagesize($_FILES["image"]["tmp_name"]);
    // if (!$check) {
    //     echo "Fake image"; // Not a valid image format
    //     $uploadOk = 0;
    //     return;
    // }

    // Check if file already exists


    // Check file size under 5MB
    // if (!checkUnderFileSize($_FILES['image']['size'])) {
    //     echo "sizeError";
    //     $uploadOk = 0;
    //     return;
    // }

    // Allow certain file formats
    // if (!checkFileExtAllowed($imageFileType)) {
    //     echo "extError";
    //     $uploadOk = 0;
    //     return;
    // }

    // If everything is ok, try to upload file
    // if (move_uploaded_file($_FILES["image"]["tmp_name"], __DIR__ . "/../" . $targetFile)) {
    //     $sql = "INSERT INTO clients (matchmaker_id, gender, first_name, last_name, dob, photo_path, education, occupation, contact, location, description) VALUES (:matchmaker_id, :gender, :first_name, :last_name, :dob, :photo_path, :education, :occupation, :contact, :location, :description)";

    //     $params = [
    //         // match parameters to values
    //         ':matchmaker_id' => $matchmaker_id,
    //         ':gender' => $gender,
    //         ':first_name' => $first_name,
    //         ':last_name' => $last_name,
    //         ':dob' => $DOB,
    //         ':photo_path' => $targetFile,
    //         ':education' => $education,
    //         ':occupation' => $address,
    //         ':contact' => $contact,
    //         ':location' => $address,
    //         ':description' => $description
    //     ];

    //     $stmt = $db->executePreparedStatement($sql, $params);
    //     echo "success"; // Image uploaded successfully
    // } else {
    //     echo "fileError"; // Error uploading file
    // }

}
?>