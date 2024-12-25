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
					$class_query = mysqli_query($conn, "SELECT * FROM teacher_class
                        LEFT JOIN class ON class.class_id = teacher_class.class_id
                        LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                        WHERE teacher_class_id = '$get_id'") or die(mysqli_error($conn));
					$class_row = mysqli_fetch_array($class_query);
					?>

					<ul class="breadcrumb">
						<li><a href="#" class="text-primary">Kelas: <?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
						<li><a href="#" class="text-primary">Kode Mata Pelajaran: <?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span></li>
						<li><a href="#" class="text-primary">Tahun Ajaran: <?php echo $class_row['school_year']; ?></a> <span class="divider">/</span></li>
						<li><b class="text-dark">Tugas yang Diunggah</b></li>
					</ul>
					<!-- End Breadcrumb -->

					<!-- Block -->
					<div id="block_bg" class="block">
						<div class="navbar navbar-inner block-header bg-secondary text-white">
							<?php
							$query = mysqli_query($conn, "SELECT * FROM assignment WHERE class_id = '$get_id' ORDER BY fdatein DESC") or die(mysqli_error($conn));
							$count  = mysqli_num_rows($query);
							?>
							<div class="muted pull-right">
								<span class="badge badge-info">Jumlah Tugas: <?php echo $count; ?></span>
							</div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<?php
								if ($count == '0') {
								?>
									<div class="alert alert-info">Tidak ada tugas yang diunggah saat ini</div>
								<?php
								} else {
								?>
									<div class="table-responsive" style="padding: 15px;">
										<table class="table table-striped table-bordered">
											<thead class="thead-dark">
												<tr>
													<th>Tanggal Unggah</th>
													<th>Nama Berkas</th>
													<th>Deskripsi</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
												while ($row = mysqli_fetch_array($query)) {
													$id  = $row['assignment_id'];
													$floc = $row['floc'];
												?>
													<tr>
														<td><?php echo $row['fdatein']; ?></td>
														<td><?php echo $row['fname']; ?></td>
														<td><?php echo $row['fdesc']; ?></td>
														<td>
															<div class="d-flex flex-column flex-md-row gap-2">
																<?php if ($floc != "") { ?>
																	<a data-placement="bottom" title="Unduh" id="<?php echo $id; ?>download" class="btn btn-primary btn-sm" href="<?php echo $row['floc']; ?>" download>
																		<i class="icon-download icon-large"></i> Unduh
																	</a>
																<?php } ?>
																<form id="assign" method="post" action="submit_assignment.php<?php echo '?id=' . $get_id ?>&<?php echo 'post_id=' . $id ?>">
																	<input type="hidden" name="id" value="<?php echo $id; ?>">
																	<button data-placement="bottom" title="Kirim Tugas" id="<?php echo $id; ?>submit" class="btn btn-success btn-sm" name="btn_assign">
																		<i class="icon-upload icon-large"></i> Kirim Tugas
																	</button>
																</form>
															</div>
														</td>
													</tr>
													<script type="text/javascript">
														$(document).ready(function() {
															$('#<?php echo $id; ?>submit').tooltip('show');
															$('#<?php echo $id; ?>submit').tooltip('hide');
															$('#<?php echo $id; ?>download').tooltip('show');
															$('#<?php echo $id; ?>download').tooltip('hide');
														});
													</script>
												<?php
												}
												?>
											</tbody>
										</table>
									</div>
								<?php
								}
								?>
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
