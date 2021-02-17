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

    $sql = "SELECT customerName, country, city, phone FROM customers GROUP BY country ORDER BY country";
    $result = mysqli_query($conn, $sql);


    if (mysqli_num_rows($result) > 0) {
       // output data of each row
        echo'
            <table>
                <tr>
                    <th>Name</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Phone number</th>
                </tr>
        ';
       while($row = mysqli_fetch_assoc($result)) {
           echo '
                <tr>
                    <td>', $row["customerName"], '</a> ', '</td>
                    <td>', $row["country"], '</td>
                    <td>', $row["city"], '</td>
                    <td>', $row["phone"], '</td>
              </tr>
            
           
           ';
       }
        echo'</table>';
       } else {
       echo 'We appear to be having trouble with our website - we\'re working on it! Sorry for the inconvenience';
    }
    mysqli_close($conn);
} catch (Exception $e) {
    echo 'We appear to be having trouble with our website - we\'re working on it! Sorry for the inconvenience';
    echo '<!-- '.$e.' -->';
}
require_once('footer.php');
?>