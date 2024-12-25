<?php 
include('header_dashboard.php'); 
include('session.php'); 
$get_id = $_GET['id']; 
?>

<body>
	<?php include('navbar_student.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('class_link.php'); ?>
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- Breadcrumb -->
                    <?php 
                    $query = mysqli_query($conn, "SELECT * FROM teacher_class_student
                        LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id
                        JOIN class ON class.class_id = teacher_class.class_id
                        JOIN subject ON subject.subject_id = teacher_class.subject_id
                        WHERE student_id = '$session_id'") or die(mysqli_error($conn));

                    $row = mysqli_fetch_array($query);
                    $id = $row['teacher_class_student_id'];
                    ?>

                    <ul class="breadcrumb">
                        <li><a href="#">Kelas: <?php echo $row['class_name']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#">Mata Pelajaran: <?php echo $row['subject_code']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#">Tahun Ajaran: <?php echo $row['school_year']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><b>Teman Sekelas</b></a></li>
                    </ul>
                    <!-- End Breadcrumb -->

                    <!-- Block -->
                    <div id="block_bg" class="block" style="margin-top: 20px;">
                        <div class="navbar navbar-inner block-header">

                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <ul  class="da-thumbs" style="display: flex; flex-wrap: wrap; gap: 20px;">
                                    <?php
                                    $my_student = mysqli_query($conn, "SELECT * FROM teacher_class_student
                                        LEFT JOIN student ON student.student_id = teacher_class_student.student_id
                                        INNER JOIN class ON class.class_id = student.class_id
                                        WHERE teacher_class_id = '$get_id' ORDER BY lastname") or die(mysqli_error($conn));

                                    while ($row = mysqli_fetch_array($my_student)) {
                                        $id = $row['teacher_class_student_id'];
                                    ?>

                                    <li id="del<?php echo $id; ?>" style="list-style: none; text-align: center;">
                                        <a class="classmate_cursor" href="#">
                                            <img id="student_avatar_class" src="admin/<?php echo $row['location']; ?>" width="124" height="140" class="img-polaroid" style="margin-bottom: 10px;">
                                            <div><span></span></div>
                                        </a>
                                        <p class="class" style="margin: 0;"> <?php echo $row['lastname']; ?></p>
                                        <p class="subject" style="margin: 0;"> <?php echo $row['firstname']; ?></p>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- End Block -->
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
</body>
</html>
