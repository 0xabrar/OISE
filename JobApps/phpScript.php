<?php
    $link = mysqli_connect('localhost', 'root', 'root', 'JobApplications');
    if (mysqli_connect_errno()) {
             echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $sID = mysqli_real_escape_string($link, $_POST['sid']);
    $jobID = mysqli_real_escape_string($link, $_POST['jobid']);
    $facultyRank = mysqli_real_escape_string($link, $_POST['facultyRank']);
    
    // insert sID, jobID, facultyRank into Applied_for 
    $sql= "INSERT INTO Applied_for (sID, jobID, facultyRank) VALUES ('$sID', '$jobID', '$facultyRank')";
    if (!mysqli_query($link,$sql)) { 
      die('Error: ' . mysqli_error($link));
    }
    
    // delete duplicate jobIDs for same sID
    $delete = mysqli_query($link, "DELETE FROM Applied_for WHERE jobAppID NOT IN (SELECT MIN(jobAppID)
                           FROM (SELECT * FROM Applied_for) as t1 GROUP BY sID,jobID)");
    
    // get all jobIDs of this sID
    $jobIDs = mysqli_query($link, "SELECT jobID FROM Applied_for WHERE sID = $sID");
    
    // get all jobAppIDs of this sID
    $jobAppIDs = mysqli_query($link, "SELECT jobAppID FROM Applied_for WHERE sID = $sID"); 

    $appliedTo = array(); // array to store all jobIDs applied to by this sID
    while($row = mysqli_fetch_array($jobIDs)){
        $appliedTo[] = (int)$row['jobID'];
    }
    
    $appIDs = array(); // array to store all jobAppIDs submitted by this sID
    while($row = mysqli_fetch_array($jobAppIDs)){
        $appIDs[] = (int)$row['jobAppID'];
    }
    
    $jsonObject['success'] = true; // set success to true
    $jsonObject['appIDs'] = $appIDs; // set appIDs's value to $appIDs array
    $jsonObject['jobIDs'] = $appliedTo; // set jobIDs value to $appliedTo array

    $json = json_encode($jsonObject); // convert php assoc. array to json object
    echo $json;
?>
