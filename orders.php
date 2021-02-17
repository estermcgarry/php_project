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

    
    if (! isset($_GET["orderNumber"])) {

        $sql = "SELECT orderNumber, orderDate, status FROM orders WHERE status='In Process' ORDER BY orderNumber DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
           // output data of each row

            echo '
                <h2>Orders in progress</h2>
                    <table>
                        <tr>
                            <th>Order Number</th>
                            <th>Order Date</th>
                            <th>Status</th>
                        </tr>
            ';

           while($row = mysqli_fetch_assoc($result)) {
                echo '
                        <tr>
                            <td> <a href="/Project3/orders.php?orderNumber=',$row["orderNumber"],'">', $row["orderNumber"], '</a> ', '</td>
                            <td>', $row["orderDate"], '</td>
                            <td>', $row["status"], '</td>
                        </tr>
                ';
           }

           echo '</table>';
        } else {
           echo 'Sorry we can\'t find that order. Please view all orders <a href="/Project3/orders.php">here</a>';
        }


        $sql = "SELECT orderNumber, orderDate, status FROM orders WHERE status='cancelled' ORDER BY orderNumber DESC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
           // output data of each row
            echo '
            <h2>Orders cancelled</h2>
                <table>
                    <tr>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        <th>Status</th>
                    </tr>
            ';
           while($row = mysqli_fetch_assoc($result)) {
                echo '
                    <tr>
                        <td> <a href="/Project3/Orders.php?orderNumber=',$row["orderNumber"],'">', $row["orderNumber"], '</a> ', '</td>
                        <td>', $row["orderDate"], '</td>
                        <td>', $row["status"], '</td>
                    </tr>
            ';
           }
            echo '</table>';
        } else {
           echo 'Sorry we can\'t find that order. Please view all orders <a href="/Project3/orders.php">here</a>';
        }

        $sql = "SELECT orderNumber, orderDate, status FROM orders ORDER BY orderDate DESC LIMIT 20";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
           // output data of each row
            echo '
            <h2>Recent orders</h2>
                <table>
                    <tr>
                        <th>Order Number</th>
                        <th>Order Date</th>
                        <th>Status</th>
                    </tr>
            ';       
           while($row = mysqli_fetch_assoc($result)) {
                echo '
                    <tr>
                        <td> <a href="/Project3/Orders.php?orderNumber=',$row["orderNumber"],'">', $row["orderNumber"], '</a> ', '</td>
                        <td>', $row["orderDate"], '</td>
                        <td>', $row["status"], '</td>
                    </tr>
                ';
           }
            echo '</table>';
        } else {
           echo 'Sorry we can\'t find that order. Please view all orders <a href="/Project3/orders.php">here</a>';
        }
    } else { // orderNumber is set
        $orderNumber = htmlspecialchars($_GET["orderNumber"]);   
        $sql = "
        SELECT 
            o.orderNumber, 
            o.orderDate, 
            o.status,
            o.comments,
            od.productCode,
            p.productLine,
            p.productName
        FROM
            orders o
            INNER JOIN orderdetails od ON o.orderNumber = od.orderNumber
            INNER JOIN products p ON od.productCode = p.productCode
        WHERE
            o.orderNumber = '".$orderNumber."'";

        $result = mysqli_query($conn, $sql);

        $firstRow = true;


        if (mysqli_num_rows($result) > 0) {
           // output data of each row
           while($row = mysqli_fetch_assoc($result)) {
               if ($firstRow) {
                    echo '
                    <h2>ORDER '.$row["orderNumber"].'</h2>
                    <table>
                    <tr>
                        <td>Order date:</td>
                        <td>', $row["orderDate"], '</td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>', $row["status"], '</td>
                    </tr>
                    <tr>
                        <td>Comments:</td>
                        <td>',$row["comments"],'</td>
                    </tr>
                    </table>
                    <br>
                    <table>
                    <tr>
                    <th>Product Name</th>
                    <th>Product Line</th>
                    <th>Product Code</th>
                    </tr>
                    ';       
                   $firstRow = false;
               }

                echo '
                    <tr>
                        <td>', $row["productName"], '</td>
                        <td>', $row["productLine"], '</td>
                        <td>', $row["productCode"], '</td>
                    </tr>
                ';
           }
            echo '</table>';
        } else {
           echo 'Sorry we can\'t find that order. Please view all orders <a href="/Project3/orders.php">here</a>';
        }
    }
       mysqli_close($conn);
} catch (Exception $e) {
    echo 'We appear to be having trouble with our website - we\'re working on it! Sorry for the inconvenience';
    echo '<!-- '.$e.' -->';
}
require_once('footer.php');
?> 