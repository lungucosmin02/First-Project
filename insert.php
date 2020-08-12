<?php
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$adress = $_POST['adress'];
$phoneCode = $_POST['phoneCode'];
$phone = $_POST['phone'];
if (!empty("username") || !empty("password") || !empty("email") || !empty("adress") ||  !empty("phoneCode") || !empty("phone")) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "users";
    /*creez conexiunea*/
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error(' . mysqli_connect_error() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT email From register Where email= ? Limit 1";
        $INSERT = "INSERT INTO register (username, password, email, adress, phoneCode, phone) values(?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email); //s-string si email mi-l inlocuieste sus
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssssii", $username, $password, $email, $adress, $phoneCode, $phone);
            $stmt->execute();
            echo "Te-ai inregistrat cu succes!";
            header("location:index.html");
        } else {
            echo "Acest email este deja utilizat!";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Toate campurile sunt obligatorii!";
    die();
}
