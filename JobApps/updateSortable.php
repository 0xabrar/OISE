<?php
    $conn = mysqli_connect('localhost', 'root', 'root', 'JobApplications');
    if (mysqli_connect_errno()) {
             echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $i = 1;
    // loop through each jobID of this sID's in the updated sortable list
    foreach ($_POST['item'] as $value) {
        echo " sid: " . $sID . " jobAppID: " . $value . " rank: " . $i . "\r\n";
        // set the rank of this jobAppID according to index/order in array 
        $sql = "UPDATE Applied_for SET rank = $i WHERE jobAppID = $value";
        if (!mysqli_query($conn,$sql)) { 
            die('Error: ' . mysqli_error($conn));
        }
        $i++; //increment counter for item_#
    }
?>