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
                    <!-- breadcrumb -->
                    <?php 
                    $class_query = mysqli_query(
                        $conn,
                        "SELECT * FROM teacher_class
                        LEFT JOIN class ON class.class_id = teacher_class.class_id
                        LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                        WHERE teacher_class_id = '$get_id'"
                    ) or die(mysqli_error($conn));
                    $class_row = mysqli_fetch_array($class_query);
                    $class_id = $class_row['class_id'];
                    $school_year = $class_row['school_year'];
                    ?>

                    <ul class="breadcrumb">
                        <li><a href="#"><?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#">Tahun Ajaran: <?php echo $class_row['school_year']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><b>Kuis Latihan</b></a></li>
                    </ul>
                    <!-- end breadcrumb -->

                    <!-- block -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <?php
                            $query = mysqli_query(
                                $conn,
                                "SELECT * FROM class_quiz 
                                LEFT JOIN quiz ON class_quiz.quiz_id = quiz.quiz_id
                                WHERE teacher_class_id = '$get_id'"
                            ) or die(mysqli_error($conn));
                            $count = mysqli_num_rows($query);
                            ?>
                            <div id="" class="muted pull-right"><span class="badge badge-info"><?php echo $count; ?></span></div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <form action="copy_file_student.php" method="post">
                                    <?php include('copy_to_backpack_modal.php'); ?>
                                    
                                    <div style="max-height: 300px; overflow-y: auto; overflow-x: hidden; padding-right: 10px;">
                                        <table cellpadding="0" cellspacing="0" border="0" class="table" id="">
                                            <thead>
                                                <tr>
                                                    <th>Judul</th>
                                                    <th>Deskripsi</th>
                                                    <th>Durasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = mysqli_query(
                                                    $conn,
                                                    "SELECT * FROM class_quiz 
                                                    LEFT JOIN quiz ON class_quiz.quiz_id = quiz.quiz_id
                                                    WHERE teacher_class_id = '$get_id' 
                                                    ORDER BY class_quiz_id DESC"
                                                ) or die(mysqli_error($conn));
                                                while ($row = mysqli_fetch_array($query)) {
                                                    $id = $row['class_quiz_id'];
                                                    $quiz_id = $row['quiz_id'];
                                                    $quiz_time = $row['quiz_time'];

                                                    $query1 = mysqli_query(
                                                        $conn,
                                                        "SELECT * FROM student_class_quiz 
                                                        WHERE class_quiz_id = '$id' 
                                                        AND student_id = '$session_id'"
                                                    ) or die(mysqli_error($conn));
                                                    $row1 = mysqli_fetch_array($query1);
                                                    
                                                    // Check if $row1 is null and safely access the grade
                                                    $grade = $row1 ? $row1['grade'] : null;
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['quiz_title']; ?></td>
                                                    <td><?php echo $row['quiz_description']; ?></td>
                                                    <td><?php echo $row['quiz_time'] / 60; ?> Menit</td>
                                                    <td width="200">
                                                        <?php if ($grade === null) { ?>
                                                            <a data-placement="bottom" title="Ikuti Kuis Ini" id="<?php echo $id; ?>Download" href="take_test.php<?php echo '?id=' . $get_id; ?>&<?php echo 'class_quiz_id=' . $id; ?>&<?php echo 'test=ok'; ?>&<?php echo 'quiz_id=' . $quiz_id; ?>&<?php echo 'quiz_time=' . $quiz_time; ?>">
                                                                <i class="icon-check icon-large"></i> Ikuti Kuis Ini
                                                            </a>
                                                        <?php } else { ?>
                                                            <b>Sudah Diikuti, Nilai: <?php echo $grade; ?></b>
                                                        <?php } ?>
                                                    </td>
                                                    <script type="text/javascript">
                                                        $(document).ready(function () {
                                                            $('#<?php echo $id; ?>Take This Quiz').tooltip('show');
                                                            $('#<?php echo $id; ?>Take This Quiz').tooltip('hide');
                                                        });
                                                    </script>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /block -->
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
</body>
</html>
