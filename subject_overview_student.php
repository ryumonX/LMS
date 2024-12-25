<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_student.php'); ?>

    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('class_link.php'); ?>

            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- Breadcrumb -->
                    <?php
                    $class_query = mysqli_query($conn, "
                        SELECT * FROM teacher_class
                        LEFT JOIN class ON class.class_id = teacher_class.class_id
                        LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                        WHERE teacher_class_id = '$get_id'
                    ") or die(mysqli_error($conn));
                    $class_row = mysqli_fetch_array($class_query);
                    ?>

                    <ul class="breadcrumb">
                        <li><a href="#"><?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><b>Subject Overview</b></a></li>
                    </ul>
                    <!-- End Breadcrumb -->

                    <!-- Block -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div id="" class="muted pull-left"></div>
                        </div>

                        <div class="block-content collapse in">
                            <div class="span12">
                                <?php
                                $query = mysqli_query($conn, "
                                    SELECT * FROM teacher_class
                                    LEFT JOIN class ON class.class_id = teacher_class.class_id
                                    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                                    LEFT JOIN teacher ON teacher.teacher_id = teacher_class.teacher_id
                                    WHERE teacher_class_id = '$get_id'
                                ") or die(mysqli_error($conn));
                                $row = mysqli_fetch_array($query);
                                $id = $row['teacher_class_id'];
                                ?>

                                <!-- Instructor Info -->
                                <p>Instructor: <strong><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></strong></p>
                                <br>
                                <img id="avatar" class="img-polaroid" src="admin/<?php echo $row['location']; ?>" width="100">
                                <!-- <p><a href=""><i class="icon-search"></i> view info</a></p> -->
                                <hr>

                                <!-- Subject Overview Content -->
                                <?php
                                $query_subject = mysqli_query($conn, "
                                    SELECT * FROM teacher_class
                                    LEFT JOIN class_subject_overview ON class_subject_overview.teacher_class_id = teacher_class.teacher_class_id
                                    WHERE class_subject_overview.teacher_class_id = '$get_id'
                                ") or die(mysqli_error($conn));

                                $row_subject = mysqli_fetch_array($query_subject);
                                ?>

                                <?php
                                if ($row_subject && isset($row_subject['content'])) {
                                    echo $row_subject['content'];
                                } else {
                                    echo "Tidak ada gambaran mata pelajaran tersedia.";
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <!-- End Block -->
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <?php include('script.php'); ?>
</body>

</html>
