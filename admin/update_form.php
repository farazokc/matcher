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
    public $requiredFields = ['name', 'age', 'gender', 'cnic', 'cast', 'maslak', 'marital_status', 'education', 'req_age', 'req_cast', 'req_maslak', 'req_marital_status', 'req_education', 'req_city', 'req_country'];

    public function __construct()
    {
        //client id recieved by appending into formData object
        $this->client_id = $_POST['client_id'];
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
                echo "error in checking required fields";
                return;
            }
        }

        $this->checkFormFields();

        $sql = "UPDATE clients 
        SET 
            matchmaker_id = :matchmaker_id,
            name = :name,
            age = :age,
            gender = :gender,
            cnic = :cnic,
            cast = :cast,
            maslak = :maslak,
            mother_tongue = :mother_tongue,
            height = :height,
            complexion = :complexion,
            marital_status = :marital_status,
            div_reason = :div_reason,
            children = :children,
            education = :education,
            job = :job,
            business = :business,
            income = :income,
            area = :area,
            city = :city,
            province = :province,
            country = :country,
            full_address = :full_address,
            home_type = :home_type,
            home_size = :home_size,
            belongs = :belongs,
            family_status = :family_status,
            father = :father,
            mother = :mother,
            sisters = :sisters,
            brothers = :brothers,
            req_age = :req_age,
            req_cast = :req_cast,
            req_height = :req_height,
            req_family_status = :req_family_status,
            req_maslak = :req_maslak,
            req_marital_status = :req_marital_status,
            req_education = :req_education,
            req_city = :req_city,
            req_country = :req_country
        WHERE
            id = :client_id;";

        $params = [
            // match parameters to values
            ':client_id' => $this->client_id,
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

    $client = new clientModel();
    $client->insertToDB();
}
?>