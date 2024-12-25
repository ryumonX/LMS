<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<body>
	<?php include('navbar_teacher.php'); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include('teacher_sidebar.php'); ?>
			<div class="span9" id="content">
				<div class="row-fluid">
					<!-- breadcrumb -->	
					<ul class="breadcrumb">
						<?php
						$school_year_query = mysqli_query($conn, "select * from school_year order by school_year DESC") or die(mysqli_error($conn));
						$school_year_query_row = mysqli_fetch_array($school_year_query);
						$school_year = $school_year_query_row['school_year'];
						?>
						<li><a href="#"><b>Kelas Saya</b></a><span class="divider">/</span></li>
						<li><a href="#">Tahun Ajaran: <?php echo $school_year_query_row['school_year']; ?></a><span class="divider">/</span></li>
						<li><a href="#"><b>File yang Dibagikan</b></a></li>
					</ul>
					<!-- end breadcrumb -->
					<!-- block -->
					<div id="block_bg" class="block">
						<div class="navbar navbar-inner block-header">
							<div id="" class="muted pull-right"></div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">
								<div class="pull-right">
									Cek Semua <input type="checkbox" name="selectAll" id="checkAll" />
									<script>
										$("#checkAll").click(function () {
											$('input:checkbox').not(this).prop('checked', this.checked);
										});
									</script>									
								</div>
								<form action="delete_shared.php" method="post">
									<a data-toggle="modal" href="#backup_delete" id="delete" class="btn btn-success" name=""><i class="icon-move icon-large"></i> Pindah</a>
									<?php include('modal_share_delete.php'); ?>
									<div class="table-responsive" style="max-height: 300px; overflow-y: auto; overflow-x: auto;">
										<table cellpadding="0" cellspacing="0" border="0" class="table table-striped">
											<thead>
												<tr>
													<th></th>
													<th>Tanggal Unggah</th>
													<th>Nama File</th>
													<th>Deskripsi</th>
													<th>Dibagikan Oleh</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$query = mysqli_query($conn, "select * FROM teacher_shared LEFT JOIN teacher on teacher_shared.teacher_id = teacher.teacher_id where shared_teacher_id = '$session_id' order by fdatein DESC") or die(mysqli_error($conn));
												while ($row = mysqli_fetch_array($query)) {
													$id = $row['teacher_shared_id'];
												?>												
												<tr id="del<?php echo $id; ?>">
													<td width="30">
														<input id="" class="" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
													</td>
													<td><?php echo $row['fdatein']; ?></td>
													<td><?php echo $row['fname']; ?></td>
													<td><?php echo $row['fdesc']; ?></td>
													<td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
													<td width="30"><a href="<?php echo $row['floc']; ?>"><i class="icon-download icon-large"></i></a></td>
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

<style>
/* Responsiveness for Mobile Devices */
.table-responsive {
	display: block;
	width: 100%;
	overflow-x: auto;
	-webkit-overflow-scrolling: touch;
	max-height: 300px; /* Limit height for vertical scrolling */
}

.table {
	border-collapse: collapse;
	width: 100%;
}

.table th, .table td {
	border: 1px solid #ddd;
	padding: 8px;
}

.table th {
	text-align: left;
	background-color: #f2f2f2;
	color: black;
}

@media (max-width: 768px) {
	.table th, .table td {
		white-space: nowrap;
	}
}
</style>

</html>
