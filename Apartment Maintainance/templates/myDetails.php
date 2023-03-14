<?php 
    include "../php/conn.php";

    session_start();
    $user = $_SESSION['user'];

    $sql_get_uDetail = "SELECT * FROM flats WHERE phone=$user";
    $sql_query_uDetail = mysqli_query($conn, $sql_get_uDetail);

    function getId($conn, $user) {
        $sql_getId = "SELECT * FROM flats WHERE phone=$user";
        $query_getId = mysqli_query($conn, $sql_getId);

        return mysqli_fetch_assoc($query_getId)['flatid'];
    }

    $id = getId($conn, $user);

    $sql_maintenance_uDetail = "SELECT * FROM maintenance WHERE payment_by=$id";
    $query_getMaintenanceDetail = mysqli_query($conn, $sql_maintenance_uDetail);

    $sql_get_postsBy = "SELECT * FROM posts WHERE postBy=$id";
    $query_getPostsBy = mysqli_query($conn, $sql_get_postsBy);
?>

<html>
    <head>
        <title>My Details</title>

        <style>
            table {
                margin: 15px;
            }
            table, tr, th, td {
                border: 1px solid black;
                background-color: lightgray;
            }
            td, th {
                padding: 5px;
            }
        </style>
    </head>

    <body>
        <?php 
            while ($rows_q1 = mysqli_fetch_assoc($sql_query_uDetail)) {
                $mc = $rows_q1['management'] == 0 ? "No" : "Yes";
                $tenents = $rows_q1['tenents'] == 0 ? "No" : "Yes";

                echo "
                    Block - ".$rows_q1['residing_block']."<br>
                    Flat - ".$rows_q1['flat_num']."<br>
                    Owner - ".$rows_q1['owner_name']."<br>
                    MC - ".$mc."<br>
                    Tenents - ".$tenents."<br>
                    Phone - ".$rows_q1['phone']."
                ";
            }

            echo "<table>";
            echo "
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Payment ID</th>
                </tr>
            ";

            while ($rows_q2 = mysqli_fetch_assoc($query_getMaintenanceDetail)) {
                echo "
                    <tr>    
                        <td>".$rows_q2['payment_id']."</td>
                        <td>".$rows_q2['amount']."</td>
                        <td>".$rows_q2['payment_date']."</td>
                        <td>".$rows_q2['paymentUniId']."</td>
                    </tr>
                ";
            }

            echo "</table>";

            echo "<table>";
            echo "
                <tr>
                    <th>#</th>
                    <th>Post</th>
                    <th>Date</th>
                    <th>Agreed</th>
                    <th>Disagreed</th>
                </tr>
            ";

            while ($rows_q3 = mysqli_fetch_assoc($query_getPostsBy)) {
                echo "
                    <tr> 
                        <td>".$rows_q3['postId']."</td>
                        <td>".$rows_q3['post']."</td>
                        <td>".$rows_q3['addedOn']."</td>
                        <td>".$rows_q3['agree_count']."</td>
                        <td>".$rows_q3['disagree_count']."</td>
                    </tr>
                ";
            }

            echo "</table>";
        ?>

        <a href="./edit.html">Edit details</a>

        <a href="./home.php">Go back to home</a>
    </body>
</html>
