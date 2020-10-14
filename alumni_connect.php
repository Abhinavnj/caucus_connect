<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    
    require './php-mail/Exception.php';
    require './php-mail/PHPMailer.php';
    require './php-mail/SMTP.php';

    $first_name = filter_input(INPUT_POST,'first_name');
    $last_name = filter_input(INPUT_POST,'last_name');
    $email = filter_input(INPUT_POST,'email');
    $phone = filter_input(INPUT_POST,'phone');
    $grad_year = filter_input(INPUT_POST,'grad_year');
    $major = filter_input(INPUT_POST,'major');
    $industry = filter_input(INPUT_POST,'industry');
    $company = filter_input(INPUT_POST,'company');
    $gen_area = filter_input(INPUT_POST,'gen_area');
    $specific_area = filter_input(INPUT_POST,'specific_area');
    $school = filter_input(INPUT_POST,'school');

    if (strcmp(substr($school, 0, 6), "Select") == 0) {
        $school = "N/A";
    }
    if (strcmp(substr($gen_area, 0, 6), "Select") == 0) {
        $gen_area = "N/A";
    }
    if (strcmp(substr($specific_area, 0, 6), "Select") == 0) {
        $specific_area = "N/A";
    }

    // $priority_school = filter_input(INPUT_POST,'priority_school');
    // $priority_area = filter_input(INPUT_POST,'priority_area');

    function sendgmail($first_name, $email) {
        //email using PHPMailer
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output        
        $mail->SMTPSecure = "ssl";                                  // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'caucusconnect@gmail.com';              // SMTP username
        $mail->Password   = 'Secaucus07094';                        // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;

        $mail->setFrom('caucusconnect@gmail.com', 'Caucus Connect');
        $mail->addAddress($email, $first_name);
        $mail->addReplyTo('caucusconnect@gmail.com', 'Caucus Connect');

        // Content
        $message = "Hello {$first_name},<br>You have been registered with Caucus Connect!<br><br>Best wishes,<br>Abhinav";
        $message = wordwrap($message,70);
        $subject = "Caucus Connect Registration Confirmation";
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;
        // send email
        $mail->send();
    }

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($phone) && !empty($grad_year) && !empty($major) && !empty($gen_area) && !empty($specific_area) && !empty($school)) {
        $host = "localhost";
        $dbusername = "u855225069_ccroot";
        $dbpassword = "Secaucus!2345";
        $dbname = "u855225069_users";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        }
        else {
            $SELECT = "SELECT email FROM alumni WHERE email = ? LIMIT 1";
            $INSERT = "INSERT INTO alumni(first_name, last_name, grad_year, email, phone, gen_area, specific_area, school, major, industry, company) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
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
                // $stmt->bind_param("sssissss", '$first_name','$last_name','$email','$phone', '$area', '$school','$priority_area','$priority_school');
                $stmt->bind_param("ssissssssss", $first_name, $last_name, $grad_year, $email, $phone, $gen_area, $specific_area, $school, $major, $industry, $company);
                $stmt->execute();
                sendgmail($first_name, $email);
                echo "You have been registered sucessfully! To confirm, you can check out our alumni page which can be accessed from the menu on our home page. If there is an error, please let us know at caucusconnect@gmail.com.";
            }
            else {
                $message = "Someone already registered using this email";
                echo "<script type='text/javascript'>alert('$message');</script>";
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
?>