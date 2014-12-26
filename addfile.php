<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>Plupload - jQuery UI Widget</title>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" >
<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" >
<link href="css/ui-lightness/jquery-ui-1.10.4.min.css" rel="stylesheet" type="text/css" />
<link href="css/jquery.ui.plupload.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.js"></script>

<!-- production -->
<script type="text/javascript" src="js/plupload.full.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.plupload.js"></script>


<!-- debug 
<script type="text/javascript" src="../../js/moxie.js"></script>
<script type="text/javascript" src="../../js/plupload.dev.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
-->

</head>
<body style="font: 13px Verdana; background: #eee; color: #333">

<h1>jQuery UI Widget</h1>

<p>You can see this example with different themes on the <a href="http://plupload.com/example_jquery_ui.php">www.plupload.com</a> website.</p>

<form id="form" method="post" action="./manage-image.php">
	<div id="uploader">
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
	</div>
	<br />
	<input type="submit" class="btn btn-primary btn-lg" value="อัพโหลดครบแล้ว ไปทำขั้นตอนที่ 2 ต่อ" />
</form>

<!-- modal error -->
<div class="modal fade =" id="error-upload" tabindex="-1" role="dialog" aria-labelledby="error-upload-label" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content alert alert-danger">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="error-upload-label">มีข้อผิดพลาด</h4>
	  </div>
	  <div class="modal-body">
		คุณต้องอัพโหลดอย่างน้อย 1 ไฟล์ก่อนดำเนินการขั้นต่อไป
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">รับทราบ</button>
	  </div>
	</div>
  </div>
</div>

<script type="text/javascript">
var uploadNo = 0;
// Initialize the widget when the DOM is ready
$(function() {
	$("#uploader").plupload({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : './upload.php?action=upload',

		// User can upload no more then 20 files in one go (sets multiple_queues to false)
		max_file_count: 20,
		
		chunk_size: '1mb',

		/*// Resize images on clientside if we can
		resize : {
			width : 200, 
			height : 200, 
			quality : 90,
			crop: true // crop to exact dimensions
		},*/
		
		filters : {
			// Maximum file size
			max_file_size : '1000mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Image files", extensions : "jpg,gif,png,webp"}
			]
		},

		// Rename files by clicking on their titles
		rename: true,
		
		// Sort files
		sortable: true,

		// Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
		dragdrop: true,

		prevent_duplicates: true,

		autostart: true,

		// Views to activate
		views: {
			list: true,
			thumbs: true, // Show thumbs
			active: 'thumbs'
		},

		// Flash settings
		flash_swf_url : 'js/Moxie.swf',

		// Silverlight settings
		silverlight_xap_url : 'js/Moxie.xap',
		// Post init events, bound after the internal events
		init : {
			PostInit: function() {
				$("#uploader .plupload_header_content .plupload_header_title").text("กรุณาเลือกไฟล์");
				$("#uploader .plupload_header_content .plupload_header_text").text("กรุณาเลือกไฟล์ที่จะอัพโหลดแล้ว ระบบจะอัพโหลดโดยอัตโนมัติ");
				
				$("#uploader .plupload_view_switch label[for=\"uploader_view_list\"]").attr("title", "ดูแบบรายการ");
				$("#uploader .plupload_view_switch label[for=\"uploader_view_thumbs\"]").attr("title", "ดูแบบรูปขนาดย่อ");

				$("#uploader .plupload_filelist_header .plupload_file_name").text("ชื่อไฟล์");
				$("#uploader .plupload_filelist_header .plupload_file_status").text("สถานะ");
				$("#uploader .plupload_filelist_header .plupload_file_size").text("ขนาดไฟล์");

				$("#uploader .plupload_content .plupload_droptext").text("ลากไฟล์มาไว้ที่นี่ (ระบบจะอัพโหลดอัตโนมัติเมื่อเพิ่มไฟล์)");
				
				$("#uploader .plupload_add .ui-button-text").text("เพิ่มไฟล์");
				$("#uploader .plupload_start .ui-button-text").text("เริ่มอัพโหลด");
			},
			FileUploaded: function(up, file, info) {
                // Called when file has finished uploading
                //console.log('RealFileName:', jQuery.parseJSON(info.response).result.realFileName, "\nFiles :", file.name);
				$("<input>")
					.attr("type","hidden")
					.attr("name","uploader_"+(uploadNo++)+"_realname")
					.attr("value",jQuery.parseJSON(info.response).result.realFileName)
					.appendTo($("#form"));
				//uploadNo++;
				//change from sent file name to real file name
				//console.log($("input[value=\""+file.name+"\"]"));
            },
		}
	});


	// Handle the case when form was submitted before uploading has finished
	$('#form').submit(function(e) {
		// Files in queue upload them first
		if ($('#uploader').plupload('getFiles').length > 0) {

			// When all files are uploaded submit form
			$('#uploader').on('complete', function() {
				$('#form')[0].submit();
			});

			$('#uploader').plupload('start');
		} else {
			$("#error-upload").modal();
		}
		return false; // Keep the form from submitting
	});
});
</script>
</body>
</html>
