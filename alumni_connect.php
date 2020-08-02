<?php
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
    // $priority_school = filter_input(INPUT_POST,'priority_school');
    // $priority_area = filter_input(INPUT_POST,'priority_area');

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($phone) && !empty($grad_year) && !empty($major) && !empty($industry) && !empty($company) && !empty($gen_area) && !empty($specific_area) && !empty($school)) {
        $host = "localhost";
        $dbusername = "id14296502_ccroot";
        $dbpassword = "Secaucus!2345";
        $dbname = "id14296502_people";

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
                $message = "New record inserted sucessfully";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            else {
                echo "Someone already registered using this email";
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