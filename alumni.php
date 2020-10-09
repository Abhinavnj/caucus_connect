<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Caucus Connect</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <style>
        #myInput {
            background-image: url('/icons-used/search.svg');
            background-position: 10px 12px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myTable tr.header {
            background-color: rgb(187, 191, 194) !important;
        }

        /* #myTable tr.header, #myTable tr:hover { */
        #myTable tr:hover {
            background-color: rgba(0, 162, 255, 0.263);
        }

        #myTable {
            font-size: 15px;
        }

        .table td, .table th {
            padding: .2rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark">
        <a class="navbar-brand" href="index.html">Caucus Connect</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="container d-flex flex-column flex-md-row justify-content-between">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-right" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-right" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-right" href="contact.html">Contact Us</a>
                </li>
                </ul>
                <div class="start-button">
                <a href="form_select.html" class="btn btn-outline-danger">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <h5>Here is a list of our alumni. Type below to filter this list.</h2>
    
    <input class ="form-control" type="text" id="myInput" placeholder="Search for area of interest or school">

    <hr>

    <div style="overflow-x:auto;">
        <table class="table table-bordered table-striped" id="myTable">
            <thead>
                <tr class="header">
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>General Area of Interest</th>
                    <th>Specific Area of Interest</th>
                    <th>School</th>
                    <th>Major</th>
                    <th>Current Industry</th>
                    <th>Company(s)</th>
                </tr>
            </thead>

            <?php
                // Connect to database
                $host = "localhost";
                $dbusername = "u855225069_ccroot";
                $dbpassword = "Secaucus!2345";
                $dbname = "u855225069_users";

                $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

                // Send error if connection error
                if ($conn-> connect_error) {
                    die("Connection failed:". $conn-> connect_error);
                }

                // Get data
                $sql = "SELECT alum_id, first_name, last_name, gen_area, specific_area, school, major, industry, company FROM alumni";
                $result = $conn-> query($sql);
                $rnum = $result->num_rows;

                // Display data
                if ($rnum > 0) {
                    while($row = $result-> fetch_assoc() ) {
                        if ($row["alum_id"] != 101) {
                            echo "<tr><td>". $row["alum_id"] ."</td><td>". $row["first_name"] ."</td><td>". $row["last_name"] ."</td><td>". $row["gen_area"] ."</td><td>". $row["specific_area"] ."</td><td>". $row["school"] ."</td><td>". $row["major"] ."</td><td>". $row["industry"] ."</td><td>". $row["company"] ."</td></tr>";
                        }
                    }
                    echo "</table>";
                }
                else {
                    echo "0 results";
                }

                // Close connection
                $conn-> close();
            ?>
        </table>
    </div>

    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>