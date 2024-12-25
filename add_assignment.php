<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
    <body id="class_div">
        <?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php include('teacher_sidebar.php'); ?>
                <div class="span9" id="content">
                    <div class="row-fluid">
                        <!-- breadcrumb -->
                        <ul class="breadcrumb">
                            <?php
                            $school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error($conn));
                            $school_year_query_row = mysqli_fetch_array($school_year_query);
                            $school_year = $school_year_query_row['school_year'];
                            ?>
                            <li><a href="#"><b>Kelas Saya</b></a><span class="divider">/</span></li>
                            <li><a href="#">Tahun Ajaran: <?php echo $school_year_query_row['school_year']; ?></a></li>
                        </ul>
                        <!-- end breadcrumb -->
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="count_class" class="muted pull-right">
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span4">
                                    <form class="" id="add_downloadble" method="post" enctype="multipart/form-data" name="upload" onsubmit="return validateForm()">
                                        <div class="control-group">
                                            <label class="control-label" for="inputEmail">Berkas</label>
                                            <div class="controls">
                                                <input name="uploaded_file" class="input-file" id="fileInput" type="file">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                                <input type="hidden" name="id" value="<?php echo $session_id ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <input type="text" name="name" Placeholder="Nama Berkas" class="input" required>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <textarea id="assigntextare" placeholder="Deskripsi" name="desc" required></textarea>
                                            </div>
                                        </div>

                                        <script>
                                            function validateForm() {
                                                // Get values of input fields
                                                var name = document.getElementsByName("name")[0].value;
                                                var desc = document.getElementsByName("desc")[0].value;
                                                
                                                // Validate if both fields are not empty
                                                if (name == "" || desc == "") {
                                                    alert("Nama Berkas dan Deskripsi harus diisi.");
                                                    return false; // Prevent form submission
                                                }
                                                return true; // Allow form submission
                                            }
                                        </script>    

                                    </div>
                                    <div class="span8">
                                        <div class="alert alert-info">Centang Kelas yang ingin Anda tambahkan berkas ini.</div>
                                        <div class="pull-left">
                                            Centang Semua <input type="checkbox" name="selectAll" id="checkAll" />
                                            <script>
                                                $("#checkAll").click(function () {
                                                    $('input:checkbox').not(this).prop('checked', this.checked);
                                                });
                                            </script>
                                        </div>
                                        <table cellpadding="0" cellspacing="0" border="0" class="table" id="">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Kelas</th>
                                                    <th>Kode Mata Pelajaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $query = mysqli_query($conn,"select * from teacher_class
                                                        LEFT JOIN class ON class.class_id = teacher_class.class_id
                                                        LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                                                        where teacher_id = '$session_id' and school_year = '$school_year' ")or die(mysqli_error($conn));
                                                $count = mysqli_num_rows($query);
                                                
                                                while($row = mysqli_fetch_array($query)){
                                                    $id = $row['teacher_class_id'];
                                                ?>                             
                                                <tr id="del<?php echo $id; ?>">
                                                    <td width="30">
                                                        <input id="" class="" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                    </td>
                                                    <td><?php echo $row['class_name']; ?></td>
                                                    <td><?php echo $row['subject_code']; ?></td>                                                                   
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="span10">
                                        <hr>
                                        <center>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <button name="Upload" type="submit" value="Upload" class="btn btn-success" /><i class="icon-upload-alt"></i>&nbsp;Unggah</button>
                                                </div>
                                            </div>
                                        </center>
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
