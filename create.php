<?php
//adding client to the DB 
//connect to the DB 
$servername = "localhost";
$username = "root";
$password ="";
$database = "testing";

//create the connection 
$connection = new mysqli($servername, $username, $password, $database);



//reading the submit data 

//first initialise it to be empty and then add these variables 
//to the value part of the form 
$name = "";
$email ="";
$address="";
$phone="";
// we will use these to fill the form


$errorMessage =""; //just normal initialising
$successMessage =""; 

//now check if the data has been transmitted using the POST method 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //then initialise the above variables with the data from the FORM 
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    //also checks if there are any empty fields 
    do {
        if (empty($name)||empty($email)||empty($phone)||empty($address) ) {
            //display the error message 
            $errorMessage = "All fields are required";
            break;
        }

        //if no empty fields, 
        //then enter the user into the DB
        $sql = "INSERT INTO users (name, email, phone, address)" . "VALUES ('$name','$email','$phone','$address')";
        $result = $connection -> query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection -> error;
            break; //exit the while loop 
        }
        //initialise the variables to empty again
        $name = "";
        $email ="";
        $address="";
        $phone="";
        //display success message 
        $successMessage = "User added!!";

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