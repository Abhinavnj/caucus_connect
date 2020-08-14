<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <title>Record Inserted</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <h3>You will be contacted as soon as you are matched with one of our alumni!</h3>
</body>
</html> -->

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require './php-mail/Exception.php';
    require './php-mail/PHPMailer.php';
    require './php-mail/SMTP.php';

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

    // Function to send email to alumni
    // function sendmail($email, $alum_id, $connection, $first_name) {
    function sendmail($email, $alum_id, $first_name) {
        $host = "localhost";
        $dbusername = "id14296502_ccroot";
        $dbpassword = "Secaucus!2345";
        $dbname = "id14296502_people";

        $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);
        
        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        }
        else {
            $SELECT = "SELECT first_name, last_name, email FROM alumni WHERE alum_id = '{$alum_id}' LIMIT 1";
            $result = $connection->query($SELECT);
            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                $alum_first = $row["first_name"];
                $alum_last = $row["last_name"];
                $alum_email = $row["email"];

                // email data
                // $email = "abhinavnj@gmail.com";
                $to = $email;
                $subject = "Caucus Connect Registration Information";
                $message = "Hello {$first_name},\nHere is the alumni information you requested:\nName: {$alum_first} {$alum_last}\nEmail: {$alum_email}";
                $message = wordwrap($message,70); // use wordwrap() if lines are longer than 70 characters
                $headers = 'From: caucusconnect@gmail.com' . "\r\n" .
                           'Reply-To: caucusconnect@gmail.com' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();
            
                // send email
                echo " You will shortly recieve an email with the contact information of the person you requested.";
                mail($to, $subject, $message, $headers);
            } else {
                echo "0 results";
            }
        }
    }

    function sendgmail($email, $alum_id, $first_name) {
        $host = "localhost";
        $dbusername = "id14296502_ccroot";
        $dbpassword = "Secaucus!2345";
        $dbname = "id14296502_people";

        $connection = new mysqli($host, $dbusername, $dbpassword, $dbname);
        
        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        }
        else {
            $SELECT = "SELECT first_name, last_name, email FROM alumni WHERE alum_id = '{$alum_id}' LIMIT 1";
            $result = $connection->query($SELECT);
            if ($result->num_rows > 0) {
                // output data of each row
                $row = $result->fetch_assoc();
                $alum_first = $row["first_name"];
                $alum_last = $row["last_name"];
                $alum_email = $row["email"];

                //email PHPMailer
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                // $mail->isSMTP();           
                $mail->SMTPSecure = "ssl";                                 // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                 // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'caucusconnect@gmail.com';              // SMTP username
                $mail->Password   = 'Secaucus07094';                        // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 465;

                $mail->setFrom('caucusconnect@gmail.com', 'Caucus Connect');
                $mail->addAddress($email, $first_name);
                $mail->addReplyTo('caucusconnect@gmail.com', 'Caucus Connect');

                // Content
                $message = "Hello {$first_name},<br>Here is the alumni information you requested:<br>Name: {$alum_first} {$alum_last}<br>Email: {$alum_email}";
                $message = wordwrap($message,70);
                $subject = "Caucus Connect Registration Information";
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->AltBody = $message;
                // send email
                $mail->send();
                echo " You will shortly recieve an email with the contact information of the person you requested.";
            } else {
                echo "0 results";
            }
        }
    }

    try {

    if (strpos($gmail, 'sboe') !== false || strpos($gmail, 'caucusconnect') !== false || strpos($gmail, 'abhinavnj') !== false) {


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
                //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                // }

                //Prepare statement
                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($email);
                $stmt->store_result();
                $rnum = $stmt->num_rows;
                // if ($rnum==0 && sendmail($email, $alum_id, $conn, $first_name)) {
                if ($rnum==0) {
                    if ($toUpdate == "0") {
                        $stmt->close();
                        $stmt = $conn->prepare($INSERT);
                        $stmt->bind_param("sssssssi", $first_name, $last_name, $email, $phone, $area, $school, $priority, $alum_id);
                        // $stmt->bind_param("sssssss", $first_name, $last_name, $email, $phone, $area, $school, $priority); //GOOD
                        $stmt->execute();
                        $message = "New record inserted sucessfully";
                        echo "You will be contacted as soon as you are matched with one of our alumni! <script type='text/javascript'>alert('$message');</script>";
                        // sendmail($email, $alum_id, $conn, $first_name);
                        sendgmail($email, $alum_id, $first_name);
                    }
                    else {
                        echo "The email you entered is not in our system. You can create a new account using this email byt resubmitting the form and selecting 'no' to updating information.";
                    }

                    /***** MATCHING *****/
                }
                else {
                    if ($email === $gmail && $toUpdate == "1") { // only allow update if google login matches entered email
                        $UPDATE_INFO = "UPDATE student 
                                        SET first_name='$first_name', last_name='$last_name', phone='$phone', area='$area', school='$school', priority='$priority', alum_id='$alum_id'
                                        WHERE email='$email'";

                        if ($conn->query($UPDATE_INFO) === TRUE) {
                            echo "Record updated successfully.";
                            sendgmail($email, $alum_id, $first_name);
                        }
                        else {
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