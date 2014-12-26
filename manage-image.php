<?php
	require dirname(__FILE__).'/connectdb.php';
	$imageList = array();
	if(isset($_GET['ajax'])) :

	else :
		if(isset($_GET['save'])){

		}
		else if(isset($_POST['uploader_count'])){
			$_POST['uploader_count'] = (int) $_POST['uploader_count'];
			for($i = 0; $i<$_POST['uploader_count']; $i++){
				if($_POST["uploader_{$i}_status"]){
					$filepath = $folderConfig['temporary_cover'].DIRECTORY_SEPARATOR.$_POST["uploader_{$i}_realname"];
					if(is_file($filepath)){
						$imageList[] = array(
							'filepath'	=>	$filepath,
							'filename'	=>	$_POST["uploader_{$i}_realname"],
							'slug'		=>	$_POST["uploader_{$i}_name"],
							'photographer'	=>	'',
							'type'		=>	'temp'
						);
					}
					
				}
			}
		}
		else{
			//get file in DB
			$result = $db->query("SELECT * FROM `pcc_cover_template`");
			if(!empty($result) && $result->num_rows > 0){
				while (($item = $result->fetch_assoc())) {
					$filepath = $folderConfig['template_cover']. DIRECTORY_SEPARATOR .$item['filename'];
					if(is_file($filepath)){
						$imageList[] = array(
							'filepath'	=>	$filepath,
							'filename'	=>	$item['filename'],
							'slug'		=>	$item['slug'],
							'photographer'	=>	$item['photographer'],
							'type'		=>	'real'
						);
					}
				}
			}
		}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>จัดการรูปภาพ</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/switch-checkbox.css">
	<style type="text/css">
		header{
			background-color: #1e2166;
			color: white;
		}
		#image img{
			width: 100%;
			height: auto;
			padding: 5px; 
			border: solid 1px #EFEFEF;
			-webkit-transition:All 1s ease;
			   -moz-transition:All 1s ease;
			     -o-transition:All 1s ease;
			        transition:All 1s ease;
		}
		#image .thumbnail:hover img{
			border: solid 1px #CCC; 
			-webkit-box-shadow: 1px 1px 5px #999;
			   -moz-box-shadow: 1px 1px 5px #999; 
			        box-shadow: 1px 1px 5px #999;
		}
		#ftpdetail{
			display: none;
		}
	</style>
</head>
<body>
	<header class="container-fluid">
		<div class="container">
			<div class="row">
				<h1>แก้ไขข้อมูลรูปพื้นหลัง</h1>
			</div>
		</div>
	</header>
		<?php if(isset($_GET['save'])) : ?>
	<section class="container" id="save-result">
		<div class="row">
			<?php var_dump($_POST); ?>
		</div>
	</section>
		<?php else : ?> 
	<section class="container" id="image-manager">
		<?php if(empty($imageList)) : ?>
			<div class="row" id="image">
				<div class="col-md-12">
					ไม่มีไฟล์ให้แก้ไข
				</div>
			</div>
		<?php else : ?>
		<form role="form" action="?save" method="POST">
			<div class="row" id="image">
				<?php		foreach ($imageList AS $i => $image) : ?>
				<div class="col-md-3">
					<div class="thumbnail">
						<img src="<?php echo $image['filepath']; ?>" />
						<div class="caption">
							<div class="input-group filename" id="filename_<?php echo $i; ?>">
								<span class="input-group-addon" title="ชื่อไฟล์จริง"><i class="fa fa-file"></i></span>
								<input type="text" class="form-control" name="filename[<?php echo $i; ?>]" value="<?php echo $image['filename']; ?>" placeholder="ชื่อไฟล์"/>
								<input type="hidden" name="image_type[<?php echo $i; ?>]" value="<?php echo $image['type']; ?>" />
							</div>
							<div class="input-group slug" id="slug_<?php echo $i; ?>">
								<span class="input-group-addon" title="ชื่อรูป"><i class="fa fa-pencil"></i></span>
								<input type="text" class="form-control" name="slug[<?php echo $i; ?>]" value="<?php echo $image['slug']; ?>" placeholder="ชื่อรูป"/>
							</div>
							<div class="input-group photographer" id="photographer_<?php echo $i; ?>">
								<span class="input-group-addon" title="ผู้ถ่ายภาพ"><i class="fa fa-camera-retro"></i></span>
								<input type="text" class="form-control" name="photographer[<?php echo $i; ?>]" value="<?php echo $image['photographer']; ?>" placeholder="ผู้ถ่ายภาพ"/>
							</div>
						</div>
					</div>
				</div>		
				<?php 	endforeach; ?>
			</div>
			<div class="row" id="ftp-zone">
				<div class="col-md-4">
					<div class="form-group">
						<label for="useftp">ใช้การย้ายข้อมูลด้วย FTP (ไม่มีการเก็บชื่อผู้ใช้หรือรหัสผ่านใดๆ ไว้ใน server ทั้งสิ้น)</label>
						<div class="onoffswitch">
							<input type="checkbox" name="useftp" class="onoffswitch-checkbox" id="useftp" value="on">
							<label class="onoffswitch-label" for="useftp">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-8" id="ftpdetail">
					<div class="input-group">
						<span class="input-group-addon" title="ที่อยู่ของโฮสต์ FTP"><i class="fa fa-globe"></i></span>
						<input type="text" class="form-control" name="ftp_host" value="" placeholder="ที่อยู่ของ server:พอร์ตของ server Ex. 127.0.0.1:21" />
					</div>
					<div class="input-group">
						<span class="input-group-addon" title="ชื่อผู้ใช้ FTP"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="ftp_user" value="" placeholder="ชื่อผู้ใช้" />
					</div>
					<div class="input-group">
						<span class="input-group-addon" title="รหัสผ่าน FTP"><i class="fa fa-key"></i></span>
						<input type="password" class="form-control" name="ftp_pass" value="" placeholder="รหัสผ่าน" />
					</div>
				</div>
			</div>
			<div class="row" id="submit-zone">
				<div class="center-block">
					<input type="submit" class="btn btn-primary btn-lg" value="บันทึก!" />
				</div>
			</div>
		</form>
		<?php endif ;?>
	</section>
		<?php endif; ?>

	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#useftp").change(function(){
				if($(this).is(":checked")){
					$("#ftpdetail").slideDown();
					$("#ftpdetail").fadeIn();
				}else{
					$("#ftpdetail").slideUp();
					$("#ftpdetail").fadeOut();
				}
			});
		});
	</script>
</body>
</html>
<?php endif; ?>