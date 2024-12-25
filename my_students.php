<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
    <body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('class_sidebar.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">
						<div class="pull-right">
							<a href="add_student.php<?php echo '?id='.$get_id; ?>" class="btn btn-info"><i class="icon-plus-sign"></i> Tambah Siswa</a>
							<a onclick="window.open('print_student.php<?php echo '?id='.$get_id; ?>')"  class="btn btn-success"><i class="icon-list"></i> Daftar Siswa</a>
						</div>
						<?php include('my_students_breadcrums.php'); ?>
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-right">
								<?php 
								$my_student = mysqli_query($conn,"SELECT * FROM teacher_class_student
													LEFT JOIN student ON student.student_id = teacher_class_student.student_id 
													INNER JOIN class ON class.class_id = student.class_id where teacher_class_id = '$get_id' order by lastname ")or die(mysqli_error($conn));
								$count_my_student = mysqli_num_rows($my_student);?>
								Jumlah Siswa: <span class="badge badge-info"><?php echo $count_my_student; ?></span>
								</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<ul id="da-thumbs" class="da-thumbs">
									    <?php
												$my_student = mysqli_query($conn,"SELECT * FROM teacher_class_student
												LEFT JOIN student ON student.student_id = teacher_class_student.student_id 
												INNER JOIN class ON class.class_id = student.class_id where teacher_class_id = '$get_id' order by lastname ")or die(mysqli_error($conn));
												while($row = mysqli_fetch_array($my_student)){
												$id = $row['teacher_class_student_id'];
												?>
										<li id="del<?php echo $id; ?>">
												<a href="#">
														<img id="student_avatar_class" src ="admin/<?php echo $row['location'] ?>" width="124" height="140" class="img-polaroid">
													<div>
													<span>
													<p><?php ?></p>
													
													</span>
													</div>
												</a>
												<p class="class"><?php echo $row['lastname'];?></p>
												<p class="subject"><?php echo $row['firstname']; ?></p>
												<a href="#<?php echo $id; ?>" data-toggle="modal"><i class="icon-trash"></i> Hapus</a>	
										</li>
										<?php include("remove_student_modal.php"); ?>
										<?php } ?>
								</ul>
										<script type="text/javascript">
											$(document).ready( function() {
												$('.remove').click( function() {
												var id = $(this).attr("id");
													$.ajax({
													type: "POST",
													url: "remove_student.php",
													data: ({id: id}),
													cache: false,
													success: function(html){
														$("#del"+id).fadeOut('slow', function(){ $(this).remove();}); 
														$('#'+id).modal('hide');
														$.jGrowl("Siswa berhasil dihapus", { header: 'Siswa Dihapus' });
													}
													}); 	
													return false;
												});				
											});
										</script>
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
