<?php require("connection.php"); ?>
<?php require_once("classes/SessionHandle.php"); ?>
<?php require_once("classes/DbCon.php"); ?>
<?php require_once("classes/Redirector.php"); ?>


<!DOCTYPE html>
<title>Profile</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&display=swap" rel="stylesheet">
<html>

<body>
    <div class="logout">
        <a href="logout.php"> <button class="logout-btn"> Log ud</button></a>
    </div>

    <div class="profile">
        <div class="top">
            <input type="hidden" name="ProfileID" value="<?php echo $_SESSION['userid']; ?>">

            <img src="./img/802001_man_512x512.png" alt="User Avatar" style="width: 100px; height: 100px;">




</form>
            
        </div>
        <form action="updateProfile.php" method="post">
            <?php
            session_start();
            $db = new DbCon();
            $profileData = $db->dbCon->prepare("SELECT * FROM `Profile` WHERE ProfileID = :profileId");
            $profileData->bindParam(':profileId', $_SESSION['userid']);
            $profileData->execute();

            $result = $profileData->fetch();
            ?>
            <h2>@<?php echo $result['Username']; ?></h2>
            <input type="hidden" name="ProfileID" value="<?php echo $result['ProfileID']; ?>">
            First name: <input type="text" name="Fname" value="<?php echo $result['Fname']; ?>">
            Last name: <input type="text" name="Lname" value="<?php echo $result['Lname']; ?>">
            Username: <input type="text" name="Username" value="<?php echo $result['Username']; ?>">
            Email: <input type="text" name="Email" value="<?php echo $result['Email']; ?>">
            Password: <input type="password" name="Pass" value="<?php echo $result['Pass']; ?>">
            <input type="submit" name="submit" value="Save">
        </form>

    </div>

</body>

    <style>
        body {

            background-image: url(./img/DWPBaggrund.jpg);
            background-attachment: fixed;
            background-size: cover;
            height: 1000vh;
            font-family: 'Montserrat', sans-serif;
        }

        .profile {
            background: white;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
            margin-bottom: 10px;
        }

        form {
            text-align: left;
            display: flex;
            flex-direction: column;
        }


        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            width: 96%;
        }

        input[type="submit"] {
            padding: 8px;
            border: none;
            border-radius: 10px;
            background-color: rgb(204, 211, 202);
            color: white;
            cursor: pointer;
            width: 16%;
            display: flex;
            align-self: flex-end;
            justify-content: center;
            align-items: center;
        }

        .top {
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .profile img {
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .profile h2 {
            margin-bottom: 10px;
            text-align: center;
        }

        .profile p {
            margin-bottom: 5px;
            margin-left: 43px;
        }

        .logout {
            display: flex;
            justify-content: flex-end;
        }

        .logout-btn {
            background-color: #ddb3b3;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 10px;
        }
    </style>