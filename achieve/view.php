<!DOCTYPE html>
<html>
<head>
    <title>Class</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="view_style.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="header">
        <div class="header-title">Dashboard</div>
        <div class="logout">
            <a href="login.html" class="button">Logout</a>
        </div>
    </div>
    <div class="container">
        <div class="sidebar-toggle">
            <i class="fa fa-bars"></i>
        </div>

        <div class="content">
            <div id="studentDetailsContent">
                <div class="content" id="detailsModal">
                    <div class="search-container">
                        <form onsubmit="searchStudents(); return false;">
                            <input type="text" id="searchInput" placeholder="Search for names...">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                    <table class="student-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Register No</th>
                                <th>Description</th>
                                <th>Batch</th>
                                <th>Course/Event</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Number of Days</th>
                                <th>Organized By</th>
                                <th>Mode of Course</th>
                                <th>Completed Semester</th>
                                <th>Awards</th>
                                <th>Certificate link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                include 'db.php';
                                $sql = "SELECT * FROM certificate";
                                $result = $conn->query($sql);
                    
                                if ($result->num_rows > 0) {
                                    $count = 1;
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>".$count."</td>";
                                        echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                                        echo "<td>".$row['reg_no']."</td>";
                                        echo "<td>".$row['description']."</td>";
                                        echo "<td>".$row['batch']."</td>";
                                        echo "<td>".$row['name']."</td>";
                                        echo "<td>".$row['start_date']."</td>";
                                        echo "<td>".$row['end_date']."</td>";
                                        echo "<td>".$row['num_days']."</td>";
                                        echo "<td>".$row['organiser']."</td>";
                                        echo "<td>".$row['mode']."</td>";
                                        echo "<td>".$row['semester']."</td>";
                                        echo "<td>".$row['awards']."</td>";
                                        echo "<td><a href='uploads/".$row['file']."' target='_blank'>View Certificate</a></td>";
                                        echo "<td><button class='delete-button' onclick='deleteStudent(".$row['id'].")'><i class='fas fa-trash'></i></button></td>";
                                        echo "</tr>";
                                        $count++;
                                    }
                                } else {
                                    echo "<tr><td colspan='0'>No students found</td></tr>";
                                }
                    
                                $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="footer" style="background-color: #333;">
        <div>
            <div class="circle" style="background-color: #7e7e7b;">
                <a href="https://www.gvpcew.ac.in/">
                    <i class="fa fa-globe"></i>
                </a>
            </div>
            <div class="circle" style="background-color: #3b5998;">
                <a href="https://www.facebook.com/GayatriVidyaParishad.GVPW/">
                    <i class="fa fa-facebook"></i>
                </a>
            </div>
            <div class="circle" style="background-color: #1da1f2;">
                <a href="https://twitter.com/i/flow/login?redirect_after_login=%2Fgvpcew_jg">
                    <i class="fa fa-twitter"></i>
                </a>
            </div>
            <div class="circle" style="background-color: #0e76a8;">
                <a href="https://www.linkedin.com/school/gayatri-vidya-parishad-college-of-engineering-for-women-madhurawada-pin-530048-cc-jg-/?originalSubdomain=in">
                    <i class="fa fa-linkedin"></i>
                </a>
            </div>
            
            <div class="circle" style="background-color: #ff0000;">
                <a href="https://www.youtube.com/watch?v=8V05pcCkg1g">
                    <i class="fa fa-youtube"></i>
                </a>
            </div>
        </div>
        <div align="center">
            Made in India <br> Copyright &copy; 2024 GVPCEW
        </div>
    </div>

    <script>
        function deleteStudent(id) {
            var confirmation = confirm("Are you sure you want to delete this?");
            
            if (confirmation) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (this.responseText.trim() === 'success') {
                            alert('Deleted successfully.');
                            location.reload();
                        } else {
                            alert('Error in deleting.');
                        }
                    }
                };
                xhttp.open("GET", "delete.php?id=" + id, true);
                xhttp.send();
            }
        }

        function searchStudents() {
            var input, filter, table, tr, td, i, j, txtValue, found;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementsByClassName("student-table")[0];
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                found = false;
                for (j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
                    td = tr[i].getElementsByTagName("td")[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
