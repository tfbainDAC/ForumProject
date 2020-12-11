<?php
require_once('includes/connection.php');

    $query = $con->prepare("SELECT Fposts.postID, Fposts.title, Fusers.username, Fposts.date FROM Fposts inner join Fusers"
            . " on Fposts.userid = Fusers.id");
    // execute
    $query->execute();
    // get rows affected
    $OK = $query->rowCount();
    $count = 0;
    if($OK > 0) { 
        $result = $query->fetchall();
        foreach($result as $row) {
            $postID[$count] = $row['postID'];
            $postTitle[$count] = $row['title'];
            $postAuthor[$count] = $row['username'];
            $postDate[$count] = $row['date'];
            $count++;
        }
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forum</title>
        
        <style>
            table {
	border-collapse:collapse;
	margin:0px auto;
}

table, th, td {
	border: 1px solid black;
	padding: 5px;
}
            
        </style>
    </head>
    <body>
        <h1>Forum Posts</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>Poster</th>
                <th>Date</th>
            </tr>
            <?php for ($i = 0; $i < $OK; $i++) { ?>
            <tr>
                <td><?= $postTitle[$i]; ?></td>
                <td><?= $postAuthor[$i]; ?></td>
                <td><?= $postDate[$i]; ?></td>
                <td><a href="view_post.php?id=<?= $postID[$i]; ?>">View Post</a></td>
            </tr>
            <?php } ?>
           
        </table>
        <p><a href="new_post.php">New Post</a></p>
    </body>
</html>
