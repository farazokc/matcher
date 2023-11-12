<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');

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
    public $complexion;
    public $marital_status;
    public $div_reason;
    public $children;
    public $education;
    public $job;
    public $business;
    public $income;
    public $area;
    public $city;
    public $province;
    public $country;
    public $full_address;
    public $home_type;
    public $home_size;
    public $belongs;
    public $family_status;
    public $father;
    public $mother;
    public $sisters;
    public $brothers;
    public $req_age;
    public $req_cast;
    public $req_height;
    public $req_family_status;
    public $req_maslak;
    public $req_marital_status;
    public $req_education;
    public $req_city;
    public $req_country;
    public $image;
    public $image_name;
    public $imageFileType;
    public $img_tmp_name;
    public $targetFile;
    private $target_dir;
    public $uploadOk;

    public $requiredFields = ['name', 'age', 'gender', 'cnic', 'cast', 'maslak', 'marital_status', 'education', 'req_age', 'req_cast', 'req_maslak', 'req_marital_status', 'req_education', 'req_city', 'req_country', 'image'];

    public function __construct()
    {
        // client stuff
        $this->client_id = getIncrementId();
        $this->matchmaker_id = $_SESSION['matchmakers_id'];

        // ************** Personal Information ****************

        // ! REQUIRED FIELDS
        $this->name = strtolower($_POST['name']);
        $this->age = $_POST['age'];
        $this->gender = $_POST['gender'];
        $this->cnic = $_POST['cnic'];
        $this->cast = $_POST['cast'];
        $this->maslak = $_POST['maslak'];
        $this->marital_status = $_POST['marital_status'];
        $this->education = $_POST['education'];

        // ! OPTIONAL FIELDS
        $this->mother_tongue = $_POST['mother_tongue'];
        $this->height = $_POST['height'];
        $this->complexion = $_POST['complexion'];
        $this->div_reason = $_POST['div_reason'];
        $this->children = $_POST['children'];
        $this->job = $_POST['job'];
        $this->business = $_POST['business'];
        $this->income = $_POST['income'];

        // ************** Family Information ****************

        $this->area = $_POST['area'];
        $this->city = $_POST['city'];
        $this->province = $_POST['province'];
        $this->country = $_POST['country'];
        $this->full_address = $_POST['full_address'];
        $this->belongs = $_POST['belongs'];
        $this->family_status = $_POST['family_status'];
        $this->home_type = $_POST['home_type'];
        $this->home_size = $_POST['home_size'];

        // ************** Siblings Information ****************

        $this->father = $_POST['father'];
        $this->mother = $_POST['mother'];
        $this->sisters = $_POST['sisters'];
        $this->brothers = $_POST['brothers'];

        // ************** Requirements ****************

        // ! REQUIRED FIELDS
        $this->req_age = $_POST['req_age'];
        $this->req_cast = $_POST['req_cast'];
        $this->req_maslak = $_POST['req_maslak'];
        $this->req_marital_status = $_POST['req_marital_status'];
        $this->req_education = $_POST['req_education'];
        $this->req_city = $_POST['req_city'];
        $this->req_country = $_POST['req_country'];

        // ! OPTIONAL FIELDS
        $this->req_height = $_POST['req_height'];
        $this->req_family_status = $_POST['req_family_status'];

        // image stuff
        $this->image = $_FILES['image'];
        $this->image_name = $_FILES['image']['name'];
        $this->img_tmp_name = $_FILES['image']['tmp_name'];
        $this->target_dir = 'images' . DIRECTORY_SEPARATOR;
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
        // $this->targetFile = $this->target_dir . $this->client_id . '.' . $this->imageFileType;
        $this->targetFile = $this->target_dir . 'image' . '.' . $this->imageFileType;
        return;
    }

    public function checkImageReal()
    {
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
        $allowed = array('xbm', 'tif', 'pjp', 'apng', 'svgz', 'jpg', 'jpeg', 'ico', 'tiff', 'svg', 'jfif', 'webp', 'png', 'bmp', 'pjpeg', 'avif', 'gif');
        if (in_array($this->imageFileType, $allowed)) {
            return 1;
        }
        return 0;
    }

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
        $this->checkFormFields();

        // perform insert query with original file name. If successful, then rename file to client_id
        $sql = "INSERT INTO 
            clients (matchmaker_id, name, age, gender, cnic, cast, maslak, mother_tongue, height, complexion, marital_status, div_reason, children, education, job, business, income, area, city, province, country, full_address, home_type, home_size, belongs, family_status, father, mother, sisters, brothers, req_age, req_cast, req_height, req_family_status, req_maslak, req_marital_status, req_education, req_city, req_country) 
            VALUES (:matchmaker_id, :name, :age, :gender, :cnic, :cast, :maslak, :mother_tongue, :height, :complexion, :marital_status, :div_reason, :children, :education, :job, :business, :income, :area, :city, :province, :country, :full_address, :home_type, :home_size, :belongs, :family_status, 
            :father, :mother, :sisters, :brothers, :req_age, :req_cast, :req_height, :req_family_status, :req_maslak, :req_marital_status, :req_education, :req_city, :req_country)";

            $params = [
                ':matchmaker_id' => $this->matchmaker_id,
                ':name' => $this->name,
                ':age' => $this->age,
                ':gender' => $this->gender,
                ':cnic' => $this->cnic,
                ':cast' => $this->cast,
                ':maslak' => $this->maslak,
                ':mother_tongue' => $this->mother_tongue,
                ':height' => $this->height,
                ':complexion' => $this->complexion,
                ':marital_status' => $this->marital_status,
                ':div_reason' => $this->div_reason,
                ':children' => $this->children,
                ':education' => $this->education,
                ':job' => $this->job,
                ':business' => $this->business,
                ':income' => $this->income,
                ':area' => $this->area,
                ':city' => $this->city,
                ':province' => $this->province,
                ':country' => $this->country,
                ':full_address' => $this->full_address,
                ':home_type' => $this->home_type,
                ':home_size' => $this->home_size,
                ':belongs' => $this->belongs,
                // ':photo_path' => $this->targetFile,
                ':family_status' => $this->family_status,
                ':father' => $this->father,
                ':mother' => $this->mother,
                ':sisters' => $this->sisters,
                ':brothers' => $this->brothers,
                ':req_age' => $this->req_age,
                ':req_cast' => $this->req_cast,
                ':req_height' => $this->req_height,
                ':req_family_status' => $this->req_family_status,
                ':req_maslak' => $this->req_maslak,
                ':req_marital_status' => $this->req_marital_status,
                ':req_education' => $this->req_education,
                ':req_city' => $this->req_city,
                ':req_country' => $this->req_country,
            ];

            $stmt = $db->executePreparedStatement($sql, $params);
            if ($stmt === false) {
                echo "dbErrorInsert";
                return;
            }

            // now we have ID, so rename file
            $this->targetFile = $this->target_dir . $db->getLastInsertID() . '.' . $this->imageFileType;            

            $sql = "UPDATE clients SET photo_path = :photo_path WHERE id = :id";
            $params = [
                ':photo_path' => $this->targetFile,
                ':id' => $db->getLastInsertID(),
            ];

            $stmt = $db->executePreparedStatement($sql, $params);
            if ($stmt === false) {
                echo "dbErrorUpdate";
                return;
            }
        if (move_uploaded_file($this->img_tmp_name, __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ($this->targetFile))) {
            echo "success"; // Image uploaded successfully 
        } else {
            echo "fileError"; // Error uploading file
        }
    }

}

function getIncrementId()
{
    global $db;

    $sql = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = :db AND TABLE_NAME = :tbl';
    $params = [
        ':db' => 'DATABASE()',
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
}
?>