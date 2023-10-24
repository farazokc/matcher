<?php
include(__DIR__ . '/../session.php');

class clientModel
{
    // all form fields that are being received
    public $client_id;
    public $matchmaker_id;
    public $name;
    public $age;
    public $gender;
    public $cnic;
    public $cast;
    public $maslak;
    public $mother_tongue;
    public $height;
    public $marital_status;
    public $div_reason;
    public $education;
    public $job;
    public $business;
    public $income;
    public $area;
    public $city;
    public $country;
    public $address;
    public $belongs;
    public $family_status;
    public $home_status;
    public $contact;
    public $father_name;
    public $mother_name;
    public $sisters_count;
    public $brothers_count;
    public $req_age;
    public $req_cast;
    public $req_height;
    public $req_status;
    public $req_income;
    public $req_maslak;
    public $req_education;
    public $req_area;

    public $images = [];
    public $image_names = [];
    public $img_tmp_name = [];
    private $target_dir = "uploads/";
    public $targetFiles = [];
    public $uploadOk;

    public function __construct()
    {
        // client stuff
        $this->client_id = getIncrementId();
        $this->matchmaker_id = $_SESSION['matchmakers_id'];

        // ************** Personal Information ****************

        $this->name = strtolower($_POST['name']);
        $this->gender = $_POST['gender'];
        $this->age = $_POST['age'];
        $this->cnic = $_POST['cnic'];
        $this->cast = $_POST['cast'];
        $this->maslak = $_POST['maslak'];
        $this->mother_tongue = $_POST['mother_tongue'];
        $this->height = $_POST['height'];
        $this->marital_status = $_POST['marital_status'];
        $this->div_reason = $_POST['div_reason'];
        $this->education = $_POST['education'];
        $this->job = $_POST['job'];
        $this->business = $_POST['business'];
        $this->income = $_POST['income'];
        

        // ************** Family Information ****************

        $this->area = $_POST['area'];
        $this->city = $_POST['city'];
        $this->country = $_POST['country'];
        $this->address = $_POST['address'];
        $this->belongs = $_POST['belongs'];
        $this->family_status = $_POST['family_status'];
        $this->home_status = $_POST['home_status'];
        $this->contact = $_POST['contact'];

        // ************** Siblings Information ****************

        $this->father_name = $_POST['father_name'];
        $this->mother_name = $_POST['mother_name'];
        $this->sisters_count = $_POST['sisters_count'];
        $this->brothers_count = $_POST['brothers_count'];

        // ************** Requirements ****************
        
        $this->req_age = $_POST['req_age'];
        $this->req_cast = $_POST['req_cast'];
        $this->req_height = $_POST['req_height'];
        $this->req_status = $_POST['req_status'];
        $this->req_income = $_POST['req_income'];
        $this->req_maslak = $_POST['req_maslak'];
        $this->req_education = $_POST['req_education'];
        $this->req_area = $_POST['req_area'];

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

        $sql = 'SELECT * FROM clients WHERE matchmaker_id = :matchmaker_id AND name = :name AND cnic = :cnic AND age = :age';
        $params = [
            ':matchmaker_id' => $this->matchmaker_id,
            ':name' => $this->name,
            ':cnic' => $this->cnic,
            ':age' => $this->age,
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
            $sql = "INSERT INTO clients (matchmaker_id, gender, first_name, last_name, age, photo_path, education, occupation, contact, location, description) VALUES (:matchmaker_id, :gender, :first_name, :last_name, :age, :photo_path, :education, :occupation, :contact, :location, :description)";

            $params = [
                // match parameters to values
                ':matchmaker_id' => $this->matchmaker_id,
                ':gender' => $this->gender,
                ':first_name' => $this->first_name,
                ':last_name' => $this->last_name,
                ':age' => $this->age,
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

//     $sql = 'SELECT * FROM clients WHERE matchmaker_id = :matchmaker_id AND first_name = :first_name AND last_name = :last_name AND age = :age';
//     $params = [
//         ':matchmaker_id' => $matchmaker_id,
//         ':first_name' => $first_name,
//         ':last_name' => $last_name,
//         ':age' => $DOB,
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
    //     $sql = "INSERT INTO clients (matchmaker_id, gender, first_name, last_name, age, photo_path, education, occupation, contact, location, description) VALUES (:matchmaker_id, :gender, :first_name, :last_name, :age, :photo_path, :education, :occupation, :contact, :location, :description)";

    //     $params = [
    //         // match parameters to values
    //         ':matchmaker_id' => $matchmaker_id,
    //         ':gender' => $gender,
    //         ':first_name' => $first_name,
    //         ':last_name' => $last_name,
    //         ':age' => $DOB,
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