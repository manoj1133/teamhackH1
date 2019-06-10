<?php
include 'db.php';
$db = init_db();
session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $like=$_GET["like"];
    $id=$_GET["id"];
    $UNAME = $_SESSION['UNAME'];
    echo $id;
    if($like=="like")
    {

        $sql = "INSERT INTO likestable(id ,likeduser ) values ('$id', '$UNAME')";
        $aresult = pg_query($db, $sql);
        $pid_username=explode(",",$id);
        // Write update command to update number likes in projects table
		
        // update projectstbale set likes=likes+1 where pid=$pid_username[0] and ownername=$pid_username[1];
		
		$query="UPDATE projectsownership SET likes=likes+1 WHERE projectid='$pid_username[0]' AND ownername='$pid_username[1]'";
		$ans=pg_query($db,$query);
    }
    else
    {
        
        $sql = "DELETE from likestable where id = '$id' and likeduser = '$UNAME'";
        $aresult = pg_query($db, $sql);
        $pid_username=explode(",",$id);
        // Write update command to update number likes in projects table
        // update projectstbale set likes=likes-1 where pid=$pid_username[0] and ownername=$pid_username[1];
		$query="UPDATE projectsownership SET likes=likes-1 WHERE projectid='$pid_username[0]' AND ownername='$pid_username[1]'";
		$ans=pg_query($db,$query);
    }
    
}