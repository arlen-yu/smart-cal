<?php
session_start();
include("config.php");

$type = $_POST['type'];

if ($type == 'classExists') {
    $class = $_POST['class'];
    $sql = "SELECT id FROM classes WHERE name = '".$class."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) 
        echo 0;
    else
        echo 1;
}

if ($type == 'newClass')  {
    $class = $_POST['class'];
    $sql = "INSERT INTO classes(name, admin) VALUES ('".$class."', ".$_SESSION['id'].")";
    mysqli_query($conn, $sql);

    $sql = "SELECT id FROM classes WHERE name = '".$class."'";
    $result = mysqli_query($conn, $sql); 
    $classID = mysqli_fetch_assoc($result);

    $sql = "INSERT INTO userClassLink(user, class) VALUES (".$_SESSION['id'].", ".$classID['id'].")";
    mysqli_query($conn, $sql);
}

if ($type == 'getClasses') {
    $class = $_POST['class'];
    $query = "SELECT * userClassLink WHERE user = ".$_SESSION['id']."";
    $result = mysqli_query($conn, $sql);
    while($fetch = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
         $e = array();
         $e['class'] = $fetch['class'];
       foreach($classes as $checkClass) {
        if ($e['class'] == $checkClass){
          array_push($events, $e);
          break;
        }
       }
       unset($checkClass);
    }
    echo json_encode($events);
}

if ($type == 'inClass')  {
    $class = $_POST['class'];
    $sql = "SELECT * userClassLink WHERE user = ".$_SESSION['id']." AND class = '".$class."'";
    $result = mysqli_query($conn, $sql);
    if ($result != 0) 
        echo true;
    else
        echo false;
}

if ($type == 'joinClass') {
    $class = $_POST['class'];
    $sql = "INSERT INTO userClassLink(user, class) VALUES (".$_SESSION['id'].", '".$class."')";
    mysqli_query($conn, $sql);
}

?>