<?php require("connection.php"); ?>

<!DOCTYPE html>
<html lang="en">

<?php require("includes/header.php"); ?>


<body>
    <?php require("includes/menu.php"); ?>
    <div class="content">
        <button id="myBtn">+</button>

        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <form method="post" action="mediaInsert.php" enctype="multipart/form-data">
                    <div class="modalbox">
                        <div class="modalLeft">
                            <input class="uploadBtn" type="file" name="picture">
                        </div>
                        <div class="modalRight">
                            <label for="Title">Title</label>
                            <input class="mTitle" type="text" name="mediaTitle">
                            <label for="Description">Description</label>
                            <input class="mDesc" type="text" name="mediaDesc" rows="10" col="25">
                            <input type="submit" class="submitBtn" name="submit" value="Submit" />
                        </div>
                    </div>


                    <?php
                    /*
                    $query = "SELECT * FROM `Likess`";
                    $result = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="User-upload">
                            <?php echo $row['LikeID']; ?> Likes


                        </div>
                    <?php
                    }
                    mysqli_close($connection);
                */
                    ?>

                </form>
            </div>
        </div>
    </div>


<?php require("includes/footer.php"); ?>


</body>


</html>