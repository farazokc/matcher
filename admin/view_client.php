<!-- matchmakers/dashboard.php -->
<?php
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'session.php');
include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php');
include(__DIR__ . DIRECTORY_SEPARATOR . 'navbar.php');

// get client ID from URL
if (!isset($_GET['id'])) {
    header("Location: " . __DIR__ . DIRECTORY_SEPARATOR . "view_all.php");
    exit();
} else {
    $client_id = $_GET['id'];

    // get client information from database
    global $db;
    $sql = "SELECT * FROM clients WHERE id = :id";
    $params = [
        ':id' => $client_id
    ];
    $stmt = $db->executePreparedStatement($sql, $params);
    $result = $db->fetchRow($stmt);
    if (!$result) {
        header("Location: " . __DIR__ . DIRECTORY_SEPARATOR . "view_all.php");
        exit();
    } else {
        $client = $result;
    }
}
?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0;
        /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance: textfield;
        /* Firefox */
    }

    /* div {
        outline: 1px solid red;
    } */

    @media print {
        body {
            visibility: hidden;
        }

        #section-to-print {
            visibility: visible;
            position: absolute;
            left: 50%;
            right: 50%;
            transform: translateX(-50%);
            top: 0;
        }
    }
</style>

<div class="container" id="section-to-print">
    <main>
        <div class="text-center">
            <p class="fs-3">
                Viewing Client:
                <?php echo ucfirst($client['name']) ?>
            </p>
            <div class="mb-3"></div>
            <hr>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-3 mt-3 d-flex align-items-center justify-content-around"
                style="outline: 1px solid grey;">
                <div class="row">
                    <div class="text-center">
                        <img src="<?php echo "./../" . $client['photo_path'] ?>" alt="Image" style="max-width: 180px;">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-9 mt-3 text-center" style="outline: 1px solid grey;">
                <p class="fs-5"><strong>
                        Personal Details
                    </strong></p>
                <div class="d-flex">
                    <div class="col-6">
                        <div class="row">
                            <p><strong>Name:</strong>
                                <?php echo $client['name'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Age:</strong>
                                <?php echo $client['age'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Gender:</strong>
                                <?php echo $client['gender'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>CNIC:</strong>
                                <?php echo $client['cnic'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Cast:</strong>
                                <?php echo $client['cast'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Maslak:</strong>
                                <?php echo $client['maslak'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Marital Status:</strong>
                                <?php echo $client['marital_status'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Education:</strong>
                                <?php echo $client['education'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <p><strong>Mother Tongue:</strong>
                                <?php echo $client['mother_tongue'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Height:</strong>
                                <?php echo $client['height'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Complexion:</strong>
                                <?php echo $client['complexion'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Divorce Reason:</strong>
                                <?php echo $client['div_reason'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong># of children:</strong>
                                <?php echo $client['children'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Job:</strong>
                                <?php echo $client['job'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Business:</strong>
                                <?php echo $client['business'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Income:</strong>
                                <?php echo $client['income'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-12 col-md-6 text-center mt-3" style="outline: 1px solid grey;">
                <p class="fs-5"><strong>
                        Family Details
                    </strong></p>
                <div class="row">
                    <p><strong>Area:</strong>
                        <?php echo $client['area'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong>City:</strong>
                        <?php echo $client['city'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong>Province:</strong>
                        <?php echo $client['province'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong>Full address:</strong>
                        <?php echo $client['full_address'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong>Belongs:</strong>
                        <?php echo $client['belongs'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong>Family Status:</strong>
                        <?php echo $client['family_status'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong>Home Type:</strong>
                        <?php echo $client['home_type'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong>Home Size:</strong>
                        <?php echo $client['home_size'] ?>
                    </p>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 text-center mt-3" style="outline: 1px solid grey;">
                <p class="fs-5"><strong>
                        Sibling Details
                    </strong></p>
                <div class="row">
                    <p><strong>Father:</strong>
                        <?php echo $client['father'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong>Mother:</strong>
                        <?php echo $client['mother'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong># of Sisters:</strong>
                        <?php echo $client['sisters'] ?>
                    </p>
                </div>
                <div class="row">
                    <p><strong># of Brothers:</strong>
                        <?php echo $client['brothers'] ?>
                    </p>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 text-center mt-3" style="outline: 1px solid grey;">
                <p class="fs-5"><strong>
                        Requirements
                    </strong></p>
                <div class="d-flex">
                    <div class="col-sm-12 col-md-6">
                        <div class="row">
                            <p><strong>Age:</strong>
                                <?php echo $client['req_age'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Cast:</strong>
                                <?php echo $client['req_cast'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Maslak:</strong>
                                <?php echo $client['req_maslak'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Marital Status:</strong>
                                <?php echo $client['req_marital_status'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Education:</strong>
                                <?php echo $client['req_education'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="row">
                            <p><strong>City:</strong>
                                <?php echo $client['req_city'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Country:</strong>
                                <?php echo $client['req_country'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Height:</strong>
                                <?php echo $client['req_height'] ?>
                            </p>
                        </div>
                        <div class="row">
                            <p><strong>Family Status:</strong>
                                <?php echo $client['req_family_status'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'); ?>

<script>
    function printPage() {
        window.print();
    }
</script>

<?php
if ($_GET['mode'] == "print") {
    echo "<script>printPage();</script>";
} 

?>