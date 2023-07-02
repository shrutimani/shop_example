<?php
//establish the connection to the DB
$servername = "localhost";
$username = "root";
$password ="";
$database = "testing";
$connection = new mysqli($servername, $username, $password, $database);


//initialise
$name = "";
$email ="";
$address="";
$phone="";
$id ="";
$errorMessage =""; 
$successMessage =""; 

//check if the method is received using the GET method then we read the ID 
if ( $_SERVER['REQUEST_METHOD'] == 'GET'){
//if the id doesnt exist then redirect the user and exit 
    if ( !isset($_GET["id"])) {
        header("location: /shop_example/index.php");
        exit;
    }
    //otherwise get it from the DB 
    $id = $_GET["id"];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $connection -> query($sql);
    $row = $result -> fetch_assoc();

    //if there is no data in the database then redirect the user 
    if (!$row) {
        header("location: /shop_example/index.php");
        exit;
    }

    //otherwise read it 
    //so firstly store the data from the DB into the variables 
    //then these vars are already displayed in the form 
    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];
}
else{
    //else if it is a POST method 
    //then update the data of the user 

    //first read the data in the form 
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];


    //check that there is no empty field
    do {
        if (empty($id) || empty($name)||empty($email)||empty($phone)||empty($address) ) {
            //display the error message 
            $errorMessage = "All fields are required";
            break; //exit the while loop
        }

        //if no empty fields, 
        //then update the data of the user into the DB
        $sql = "UPDATE users" . 
                "SET name = '$name', email = '$email', phone = '$phone', address = '$address' ".
                "WHERE id = '$id' ";

        //execute the SQL query 
        $result = $connection -> query($sql);

        //check if query is executed correctly or not 
        if (!$result) {
            $errorMessage = "Invalid query: " . $connection -> error;
            break; //exit the while loop 
        }

        //otherwise display success message 
        $successMessage = "User data updated!!";

        //redirect the user to the index file 
        header("location: /shop_example/index.php");

        //exit the execution of the file 
        exit;



    }while (false);

}


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Shop</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class ="container my-5">
            <h2>New User</h2>

            <?php
            //check if the error message is not empty 
            if (!empty($errorMessage)) {
                echo "
                <div class ='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorMessage</strong>
                    <button type='button; class='btn-close' data-bs-dismiss='alert' aria-label='Close'></br>
                </div>
                ";
            }
            ?>
            <form method="post">
                <input type="hidden" name = "id" value="<?php echo $id ;?>">
                <div class ="row mb-3">
                    <label class="col-sm-3 cold-form-label">Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name ="name" value="<?php echo $name; ?>">
                    </div>
                </div>
                <div class ="row mb-3">
                    <label class="col-sm-3 cold-form-label">Email</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" name ="email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class ="row mb-3">
                    <label class="col-sm-3 cold-form-label">Phone</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name ="phone" value="<?php echo $phone; ?>">
                    </div>
                </div>
                <div class ="row mb-3">
                    <label class="col-sm-3 cold-form-label">Address</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name ="address" value="<?php echo $address; ?>">
                    </div>
                </div>

                <?php
                if (!empty($successMessage)) {
                    echo "
                    <div class='row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class ='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>$successMessage</strong>
                                <button type='button; class='btn-close' data-bs-dismiss='alert' aria-label='Close'></br>
                            </div>
                        </div>
                    </div>
                    ";
                }
                ?>
                
                <div class ="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="/shop_example/index.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>