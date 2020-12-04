<?php
require_once('includes/connection.php');
if(isset($_GET['id'])) {
    $postid = $_GET['id'];
	echo "post ID is ".$postid;
    $query = $con->prepare("SELECT * FROM Fposts, Fusers"
            . " WHERE Fposts.postID = :postid AND Fposts.userid = Fusers.id");
    // bind parameters and execute
    $query->bindParam(':postid', $postid, PDO::PARAM_INT);
    // execute
    $query->execute();
    // get rows affected
    $OK = $query->rowCount();
    if($OK >= 1) {
        $result = $query->fetchall();
        foreach($result as $row) {
            $postTitle = $row['title'];
            $postContent = $row['content'];
            $postAuthor = $row['username'];
            $postDate = $row['date']; 
        }
    }

    // Get replies
        $query = $con->prepare("SELECT Freply.replyContent, Fusers.username, Freply.replyDate "
                . "FROM Freply, Fposts, Fusers "
                . "WHERE Freply.postid = Fposts.postid "
                . "AND Freply.userid = Fusers.id "
                . "AND Fposts.postid = :postid");
    $query->bindParam(':postid', $postid, PDO::PARAM_INT);
    // execute
    $query->execute();
    // get rows affected
    $replyCount = $query->rowCount();
    $count = 0;
    if($replyCount >= 1) {
        $result = $query->fetchall();
        foreach($result as $row) {
            $replyContent[$count] = $row['replyContent'];
            $replyAuthor[$count] = $row['username'];
            $replyDate[$count] = $row['replyDate'];
            $count++;
        }
    }
}

if(isset($_POST['submit'])) {
    $userid = $_POST['userid'];
    $content = $_POST['content'];

    $query = $con->prepare('INSERT INTO Freply (replyContent, userid, postid)'
    . 'VALUES (:content, :userid, :postid)');
    // bind parameters and execute
    $query->bindParam(':content', $content, PDO::PARAM_STR);
    $query->bindParam(':userid', $userid, PDO::PARAM_INT);
    $query->bindParam(':postid', $_GET['id'], PDO::PARAM_INT);
    // execute
    $query->execute();
    header("Location: view_post.php?id=" . $_GET['id']);
}
?>
<html>
    <head><title>Post</title></head>
    <body>
        <h1><?= $postTitle; ?></h1>
        <p><?= $postContent; ?></p>
        <p>Posted by: <?= $postAuthor; ?> at <?= $postDate; ?></p>
        <hr />

            <?php for ($i = 0; $i < $replyCount; $i++) { ?>
        <p><?= $replyContent[$i]; ?></p>
        <p><i><?= $replyAuthor[$i]; ?> on <?= $replyDate[$i]; ?></i></p>
        <hr/>
            <?php } ?>

        <hr/>

        <h1>Reply</h1>
        <form method="post" action="">
            <input type="text" name="userid" placeholder="Enter userid" required/><br/>
            <textarea rows="4" cols="50" name="content" required>Enter content</textarea><br/>
            <input type="submit" name="submit" value="Post" />
        </form>
    </body>
</html>
