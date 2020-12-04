<?php
require_once('includes/connection.php');

    if(isset($_POST['submit'])) {
        $userid = $_POST['userid'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        
        $query = $con->prepare('INSERT INTO Fposts (title, content, userid)'
        . 'VALUES (:title, :content, :userid)');
        // bind parameters and execute
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':content', $content, PDO::PARAM_STR);
        $query->bindParam(':userid', $userid, PDO::PARAM_STR);
        // execute
        $query->execute();
        header("Location: index.php");
    }
?>
<html>
    <head><title>Post</title></head>
    <body>
        <h1>New Post</h1>
        <form method="post" action="">
            <input type="text" name="userid" placeholder="Enter userid" required/><br/>
            <input type="text" name="title" placeholder="Enter a title" required/><br/>
            <textarea rows="4" cols="50" name="content" required>Enter content</textarea><br/>
            <input type="submit" name="submit" value="Post" />
        </form>
        
    </body>
</html>