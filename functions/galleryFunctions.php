<?php

	function displayImages() {
        include "config/database.php";
        include "comments.php";
        include "likeFunctions.php";
        $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmnt = $dbh->prepare("SELECT * FROM user INNER JOIN image ON user.id = image.userid;");
        $stmnt->execute();
        $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $image) {
            $string = $string . "<div class='box'><img src=\"./gallery/" . $image['source'] . "\" alt=\"error\" class='image is-640x480 center'><br>";
            if (isset($_SESSION['username']))
                $string = $string . "<form action='forms/likes.php' method='post'><input type='hidden' name='imageid' value='"
            .$image['id']."'><input type='hidden' name='userid' value='".$_SESSION['id']."'></input><button type='submit'>";
            $string = $string . "<p>Likes: " . getLikeCount($image['id']);
            $string = $string . "</p></button></form><br>";
            $string = $string . getComments($image['id']);
            if (isset($_SESSION['username']))
                $string = $string."<form action='functions/storeComment.php?userid=".$_SESSION['id']."&imageid=".$image['id']."&username=".$_GET['name']."' method='post'><br>Text: <input type='text' name='text'><input type='submit' value='Post Comment'></form>";
            $string = $string ."</div>";
        }
        return ($string);
	}
?>
