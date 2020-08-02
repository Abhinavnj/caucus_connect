<!DOCTYPE html>
<html lang="en">
<head>
  <title>Record Inserted</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <h3>You will be contacted as soon as you are matched with one of our alumni!</h3>
</body>
</html>

<?php
    $first_name = filter_input(INPUT_POST,'first_name');
    $last_name = filter_input(INPUT_POST,'last_name');
    $email = filter_input(INPUT_POST,'email');
    $phone = filter_input(INPUT_POST,'phone');
    $area = filter_input(INPUT_POST,'area');
    $school = filter_input(INPUT_POST,'school');
    $priority = filter_input(INPUT_POST,'priority');
    $alum_id = filter_input(INPUT_POST,'alum_id');
    $gmail = filter_input(INPUT_POST,'gmail');
    $toUpdate = filter_input(INPUT_POST,'toUpdate');

    if ($alum_id == null) {
        $alum_id = 101;
    }

    try {

    if (strpos($gmail, 'sboe') !== false || strpos($gmail, 'caucusconnect') !== false) {


        if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($phone) && !empty($area) && !empty($school)) {
            $host = "localhost";
            $dbusername = "id14296502_ccroot";
            $dbpassword = "Secaucus!2345";
            $dbname = "id14296502_people";

            $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
            if (mysqli_connect_error()) {
                die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
            }
            else {
                $SELECT = "SELECT email FROM student WHERE email = ? LIMIT 1";
                $INSERT = "INSERT INTO student(first_name, last_name, email, phone, area, school, priority, alum_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                // $INSERT = "INSERT INTO student(first_name, last_name, email, phone, area, school, priority) VALUES(?, ?, ?, ?, ?, ?, ?)"; //GOOD
                
                // if (mysqli_query($conn, $sql)) {
                //     echo "success";
                // }
                // else {
                //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);;
                // }

                //Prepare statement
                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($email);
                $stmt->store_result();
                $rnum = $stmt->num_rows;
                if ($rnum==0) {
                    $stmt->close();
                    $stmt = $conn->prepare($INSERT);
                    $stmt->bind_param("sssssssi", $first_name, $last_name, $email, $phone, $area, $school, $priority, $alum_id);
                    // $stmt->bind_param("sssssss", $first_name, $last_name, $email, $phone, $area, $school, $priority); //GOOD
                    $stmt->execute();
                    $message = "New record inserted sucessfully";
                    echo "<script type='text/javascript'>alert('$test');</script>";

                    /***** MATCHING *****/

                }
                else {
                    // echo "Someone already registered using this email";
                    if ($email === $gmail && $toUpdate == "1") { // only allow update if google login matches entered email
                        $UPDATE_INFO = "UPDATE student 
                                        SET first_name='$first_name', last_name='$last_name', phone='$phone', area='$area', school='$school', priority='$priority', alum_id='$alum_id'
                                        WHERE email='$email'";

                        if ($conn->query($UPDATE_INFO) === TRUE) {
                            echo "Record updated successfully";
                        } else {
                            echo "Error updating record: " . $conn->error;
                        }
                    }
                    else {
                        if ($toUpdate == "0") {
                            echo "You selected no to updating information and you are using an email that has already been used to register.";
                        }
                        else {
                            echo "Login email does not match the entered email.";
                        }
                    }
                }
                $stmt->close();
                $conn->close();
            }
        }
        else {
            $message = "All fields are required";
            echo "<script type='text/javascript'>alert('$message');</script>";
            die();
        }
    }
    else {
        $message = "Must be signed in with sboe.org email address!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        die();
    }
    }
    catch (Exception $e) {
            echo 'caught exception: ', $e->getMessage(), "\n";
    }
?>