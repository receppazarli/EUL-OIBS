<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $photo = isset($_POST['photo']) ? $_POST['photo'] : 'default.jpg';
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $program = $_POST['program'];
    $semester = isset($_POST['semester']) ? $_POST['semester'] : '5';
    $gpa = isset($_POST['gpa']) ? $_POST['gpa'] : '3.8';

    
    $selectedCourses = isset($_POST['courses']) ? $_POST['courses'] : [];

    
    if (count($selectedCourses) > 5) {
        echo "You can only select a maximum of 5 courses.";
        exit;
    }

 
    echo "Login Successful Welcome :)";


}
$studentNo = $_POST['studentNo'];


$studentData = simplexml_load_file('student.xml');


$student = $studentData->xpath("//Student[StudentNo='$studentNo']")[0];



$courses = [

    'COMP117 COMPUTING FOUNDATIONS',
    'COMP124 COMPUTER PROGRAMMING',
    'COMP217 DATA STRUCTURES',
    'COMP218 OBJECT-ORIENTED PROGRAMMING I',
    'SENG212 SOFTWARE REQUIREMENTS ANALYSIS AND SPECIFICATION',
    'COMP315 OBJECT-ORIENTED PROGRAMMING II',
    'COMP339 SYSTEMS PROGRAMMING',
    'SENG305 SOFTWARE DESIGN AND ARCHITECTURE',
    'COMP342 COMPUTER NETWORKS',
    'COMP 471 JAVA PROGRAMMING'
];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    

    <Style>

                body {
                background-color: #202c3e;
                color: #ffffff;
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                }

                .container {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin: 20px;
                }

                .student-info {
                width: 40%;
                background-color: #273447;
                padding: 20px;
                border-radius: 5px;
                }

                .selected-courses {
                width: 40%;
                background-color: #273447;
                padding: 20px;
                border-radius: 5px;
                }

                h1 {
                text-align: center;
                color: #ffffff;
                }

                h2 {
                margin-top: 0;
                color: #ffffff;
                }

                form {
                margin-bottom: 20px;
                }

                input[type="text"],
                textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #ffffff;
                border-radius: 5px;
                margin-bottom: 10px;
                background-color: #273447;
                color: #ffffff;
                }

                input[type="checkbox"] {
                margin-right: 5px;
                }

                button {
                background-color: #0088cc;
                color: #ffffff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                }

                ul {
                list-style-type: none;
                padding: 0;
                }

                li {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
                }

                .delete-button {
                background-color: #ff0000;
                color: #ffffff;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
                }

               
                @media only screen and (max-width: 768px) {
                .container {
                    flex-direction: column;
                }

                .student-info,
                .selected-courses {
                    width: 100%;
                }
                }


                textarea {
            height: 200px;
            }

    </Style>
    
    <script>
      function updateSelection() {
    var selectedCourses = document.querySelectorAll('input[name="courses[]"]:checked');
    var courseList = document.getElementById('courseList');
    var courseSelectionBoxes = document.querySelectorAll('.course-selection');

    var selectedCount = selectedCourses.length;
    var selectedCourseNames = [];

    if (selectedCount > 5) {
        alert("You can only select a maximum of 5 courses.");
        
        selectedCourses[selectedCount - 1].checked = false;
        return;
    }

    courseList.innerHTML = '';

    for (var i = 0; i < selectedCount; i++) {
        var courseName = selectedCourses[i].value;
        var listItem = document.createElement('li');
        var courseInfo = document.createElement('span');
        courseInfo.textContent = courseName;
        var deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.addEventListener('click', function (courseName, listItem) {
            return function() {
              
                var correspondingCheckbox = document.querySelector('input[name="courses[]"][value="' + courseName + '"]');
                correspondingCheckbox.checked = false;

                
                for (var j = 0; j < courseSelectionBoxes.length; j++) {
                    if (courseSelectionBoxes[j].textContent === courseName) {
                        courseSelectionBoxes[j].textContent = '';
                        break;
                    }
                }

              
                courseList.removeChild(listItem);
            };
        }(courseName, listItem));

        listItem.appendChild(courseInfo);
        listItem.appendChild(deleteButton);
        courseList.appendChild(listItem);

        selectedCourseNames.push(courseName);
    }

    
    for (var k = 0; k < courseSelectionBoxes.length; k++) {
        var box = courseSelectionBoxes[k];
        var courseName = box.getAttribute('data-course');

        if (selectedCourseNames.includes(courseName)) {
            box.textContent = courseName;
        } else {
            box.textContent = '';
        }
    }
}

function sendEmail() {
        

        var message = document.querySelector('textarea[name="message"]').value;

        
        var senderName = "Recep Pazarlı";
        var senderEmail = "receppazarli99@hotmail.com";
        var receiverEmail = "student@gmail.com";

        
        var subject = "New message from " + senderName;
        var body = "Sender: " + senderName + "\n\n" + message;

        
        var mailtoUrl = "mailto:" + receiverEmail + "?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);

        
        window.location.href = mailtoUrl;
    }


</script>


</head>
<body>
    <title>Registration Form</title>
    <h1>Registration Form</h1>
    <div class="container">
        <div class="student-info">
            <h2>Student Information</h2><br>
            <form action="register.php" method="post">
                <label for="photo">Photo:</label> <br><br>
                <img src="user.jpg" alt="school logo" width="100" height="125"><br><br>

                <label for="name">Name:</label><br><br>
                <input type="text" name="name" id="name" value="<?php echo $student->Name; ?>" readonly ><br><br>

                <label for="surname">Surname:</label><br><br>
                <input type="text" name="surname" id="surname" value="<?php echo $student->Surname; ?>"readonly><br><br>

                <label for="program">Program:</label><br><br>
                <input type="text" name="program" id="program" value="<?php echo $student->Program; ?>"readonly><br><br>

                <label for="semester">Semester:</label><br><br>
                <input type="text" name="semester" id="semester" value="<?php echo $semester; ?>"readonly><br><br>

                <label for="gpa">GPA:</label><br><br>
                <input type="text" name="gpa" id="gpa" value="<?php echo $gpa; ?>"readonly><br><br>

                <h2>Course Selection</h2><br>
                <ul id="courseList1"> 
                    <?php foreach ($courses as $course): ?>
                        <li>
                            <input type="checkbox" name="courses[]" value="<?php echo $course; ?>" onchange="updateSelection()"><br>
                            <label><?php echo $course; ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" onclick="addCourse()">Add</button>

                
            </form>
            

        </div>

        <div class="selected-courses"><br>
            <h2>Selected Courses</h2>
            <ul id="courseList">
            </ul>
        </div>

        <div class="selected-courses">
            <br>
            <h2>Selected Courses</h2>
            <ul id="courseList"></ul>
            <br>

            <h2>Send Message</h2>
            <form onsubmit="sendEmail(); return false;">
                <textarea name="message" placeholder="Enter your message..."></textarea><br><br>
                <button type="submit" name="send">Send</button>
            </form>
        </div>

    </div>
</body>
</html>
