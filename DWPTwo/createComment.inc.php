<?php

require("connection.php");

    if (isset($_POST['commentSubmit'])) {
        $CommentText = htmlspecialchars(trim($_POST['CommentText']));
        $dato = htmlspecialchars(trim($_POST['dato']));
        $MediaCommentFK = $_POST['MediaID'];
        $ProfileFK = $SESSION['user_id'];

        if($conn){
            $stmt = $conn->prepare("INSERT INTO Comment (CommentText, dato, MediaCommentFK, ProfileFK) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $CommentText, $dato, $MediaCommentFK, $ProfileFK);
            
            $stmt->execute();
            $stmt->close();
            $conn->close();
            
            //header( "Location: ./index.php" );

        } else {
            die("error");
        }
    } 
