<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>

<body>
	<?php include('navbar_teacher.php'); ?>
	<div class="container-fluid">
		<div class="row-fluid">
			<?php include('teacher_sidebar.php'); ?>
			<div class="span6" id="content">
				<div class="row-fluid">
					<!-- breadcrumb -->
					<ul class="breadcrumb">
						<?php
						$school_year_query = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year DESC") or die(mysqli_error($conn));
						$school_year_query_row = mysqli_fetch_array($school_year_query);
						$school_year = $school_year_query_row['school_year'];
						?>
						<li><a href="#">Pesan</a><span class="divider">/</span></li>
						<li><a href="#"><b>Inbox</b></a><span class="divider">/</span></li>
						<li><a href="#">Tahun Ajaran: <?php echo $school_year_query_row['school_year']; ?></a><span class="divider">/</span></li>
                        <li><a href="#">Inbox Guru</a></li>
					</ul>
					<!-- end breadcrumb -->

					<!-- block -->
					<div id="block_bg" class="block">
						<div class="navbar navbar-inner block-header">
							<div id="" class="muted pull-left"></div>
						</div>
						<div class="block-content collapse in">
							<div class="span12">

								<ul class="nav nav-pills">
									<li class="active">
										<a href="teacher_message.php"><i class="icon-envelope-alt"></i> Inbox</a>
									</li>
									<li class="">
										<a href="sent_message.php"><i class="icon-envelope-alt"></i> Pesan Terkirim</a>
									</li>
								</ul>

								<div style="max-height: 300px; overflow-y: auto;">
									<?php
									$query_announcement = mysqli_query($conn, "SELECT * FROM message
                                                            LEFT JOIN teacher ON teacher.teacher_id = message.sender_id
                                                            WHERE message.reciever_id = '$session_id' ORDER BY date_sended DESC
                                                            ") or die(mysqli_error($conn));
									$count_my_message = mysqli_num_rows($query_announcement);
									if ($count_my_message != '0') {
										while ($row = mysqli_fetch_array($query_announcement)) {
											$id = $row['message_id'];
											$sender_id = $row['sender_id'];
											$sender_name = $row['sender_name'];
											$reciever_name = $row['reciever_name'];
									?>
											<div class="post" id="del<?php echo $id; ?>">

												<div class="message_content">
													<?php echo $row['content']; ?>
												</div>

												<hr>
												Dikirim oleh: <strong><?php echo $row['sender_name']; ?></strong>
												<i class="icon-calendar"></i> <?php echo $row['date_sended']; ?>
												<div class="pull-right">
													<a class="btn btn-link" href="#reply<?php echo $id; ?>" data-toggle="modal"><i class="icon-reply"></i> Balas </a>
												</div>
												<div class="pull-right">
													<a class="btn btn-link" href="#<?php echo $id; ?>" data-toggle="modal"><i class="icon-remove"></i> Hapus </a>
													<?php include("remove_inbox_message_modal.php"); ?>
													<?php include("reply_inbox_message_modal.php"); ?>
												</div>
											</div>
										<?php }
									} else { ?>
										<div class="alert alert-info"><i class="icon-info-sign"></i> Tidak ada pesan masuk</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>

					<!-- /block -->
				</div>

				<script type="text/javascript">
					$(document).ready(function() {
						$('.remove').click(function() {
							var id = $(this).attr("id");
							$.ajax({
								type: "POST",
								url: "remove_inbox_message.php",
								data: ({
									id: id
								}),
								cache: false,
								success: function(html) {
									$("#del" + id).fadeOut('slow', function() {
										$(this).remove();
									});
									$('#' + id).modal('hide');
									$.jGrowl("Pesan Anda Berhasil Dihapus", {
										header: 'Data Dihapus'
									});
								}
							});
							return false;
						});
					});
				</script>

				<script>
					jQuery(document).ready(function() {
						jQuery("#reply").submit(function(e) {
							e.preventDefault();
							var id = $('.reply').attr("id");
							var _this = $(e.target);
							var formData = jQuery(this).serialize();
							$.ajax({
								type: "POST",
								url: "reply.php",
								data: formData,
								success: function(html) {
									$.jGrowl("Pesan Berhasil Dikirim", {
										header: 'Pesan Terkirim'
									});
									$('#reply' + id).modal('hide');
								}
							});
							return false;
						});
					});
				</script>

			</div>
			<?php include('create_message.php') ?>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<?php include('script.php'); ?>
</body>

</html>