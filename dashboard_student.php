<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<body>
    <?php include('navbar_student.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('student_sidebar.php'); ?>
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- Breadcrumb -->
                    <ul class="breadcrumb">
                        <?php
                        $school_year_query = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year DESC") or die(mysqli_error($conn));
                        $school_year_row = mysqli_fetch_array($school_year_query);
                        ?>
                        <li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
                        <li><a href="#">School Year: <?php echo $school_year_row['school_year']; ?></a></li>
                    </ul>
                    <!-- End Breadcrumb -->

                    <!-- Block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-right">
                                <?php
                                $query = mysqli_query($conn, "
                                    SELECT * FROM teacher_class_student
                                    LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id 
                                    LEFT JOIN class ON class.class_id = teacher_class.class_id 
                                    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                                    LEFT JOIN teacher ON teacher.teacher_id = teacher_class.teacher_id
                                    WHERE student_id = '$session_id' AND school_year = '{$school_year_row['school_year']}'
                                ") or die(mysqli_error($conn));
                                $count = mysqli_num_rows($query);
                                ?>
                                <span class="badge badge-info"><?php echo $count; ?></span>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <ul id="da-thumbs" class="da-thumbs">
                                    <?php if ($count > 0) {
                                        while ($row = mysqli_fetch_array($query)) {
                                            $id = $row['teacher_class_id'];
                                    ?>
                                        <li>
                                            <a href="my_classmates.php?id=<?php echo $id; ?>">
                                                <img src="<?php echo $row['thumbnails']; ?>" width="124" height="140" class="img-polaroid">
                                                <div>
                                                    <span>
                                                        <p><?php echo $row['class_name']; ?></p>
                                                    </span>
                                                </div>
                                            </a>
                                            <p class="class"><?php echo $row['class_name']; ?></p>
                                            <p class="subject"><?php echo $row['subject_code']; ?></p>
                                            <p class="subject"><?php echo $row['firstname'] . " " . $row['lastname']; ?></p>
                                        </li>
                                    <?php } 
                                    } else { ?>
                                        <div class="alert alert-info">
                                            <i class="icon-info-sign"></i> Kamu tidak masuk dalam Kelas manapun
                                        </div>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Block -->
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
</body>
</html>
