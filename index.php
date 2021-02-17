<?php
require_once('header.php');
    
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";
    
try {
    //do not output error messages to end user
    error_reporting(E_ERROR | E_PARSE);
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        throw new Exception('Database oopsy: '.mysqli_connect_error());
    }

    if (! isset($_GET["productLine"])) {


        $sql = "SELECT productLine, textDescription FROM productlines";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
           // output data of each row
            echo '
            <table>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                </tr>
            
            ';
            
           while($row = mysqli_fetch_assoc($result)) {
                echo '
                    <tr>
                        <td> <a href="/Project3/index.php?productLine=',$row["productLine"],'">', $row["productLine"], '</a> ', '</td>
                        <div id="myDescription">
                        <td>', $row["textDescription"], '</td>
                        </div>
                    </tr>
                    
                ';
           }
            echo'</table>';
        } else {
           echo 'Sorry we can\'t find that product line. Please view all product lines <a href="/Project3/index.php">here</a>';
        }     
    } else{
        $productLine = htmlspecialchars($_GET["productLine"]);   
        $sql2 = "SELECT productName, productDescription FROM products WHERE productLine = '".$productLine."'";
        $result2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result2) > 0) {
           // output data of each row

            echo '
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                    </tr>
            '; 
            
           while($row = mysqli_fetch_assoc($result2)) {
                echo '
                      <tr>
                        <td id="productsProduct">', $row["productName"], '</td>
                        <td id="productsDescription">', $row["productDescription"], '</td>
                      </tr>
                ';
           }
            echo'</table>';
        } else {
           echo 'Sorry we can\'t find that product line. Please view all product lines <a href="/Project3/index.php">here</a>';
        }
    }

    mysqli_close($conn);
} catch (Exception $e) {
    echo 'We appear to be having trouble with our website - we\'re working on it! Sorry for the inconvenience';
    echo '<!-- '.$e.' -->';
}
    
require_once('footer.php');
?>
    
