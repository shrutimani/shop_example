<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customers</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container my-5">
            <h2>List of users</h2>
            <a class ="btn btn-primary" href="/shop_example/create.php" role="button">New User</a>
            <br>
            <table class ="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>PHONE</th>
                        <th>ADDRESS</th>
                        <th>CREATED</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password ="";
                    $database = "testing";

                    //create the connection 
                    $connection = new mysqli($servername, $username, $password, $database);

                    //check whether the connection has been established or not 
                    if ($connection -> connect_error){
                        die("Connection failed: " . $connection -> connect_error);
                    }

                    //else read all the data from the table 
                    $sql = "SELECT * FROM users";
                    //then execute the query and store it in $result 
                    $result = $connection -> query($sql);
                    //see whether the query has been executed without error or not 
                    //if yes, there is an error 
                    if (!$result) {
                        die("Invalid query: " . $connection -> error);
                    }
                    //else 
                    //read each data for every row
                    while ($row = $result -> fetch_assoc()){
                        echo "
                        <tr>    
                            <td>$row[id]</td>
                            <td>$row[name]</td>
                            <td>$row[email]</td>
                            <td>$row[phone]</td>
                            <td>$row[address]</td>
                            <td>$row[created_at]</td>
                            <td>
                                <a class = 'btn btn-primary btn-sm' href='/shop_example/edit.php?id=$row[id]'>EDIT</a>
                                <a class = 'btn btn-danger btn-sm' href='/shop_example/delete.php?id=$row[id]'>DELETE</a>
                            </td>
                        </tr>
                        ";
                    }


                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>