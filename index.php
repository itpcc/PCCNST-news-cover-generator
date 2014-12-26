<?php
	$imgFolder = './template';
	$creator = array(
		'IMG_0720-2.jpg'	=> 'นายธีรพัฒน์ โสนเส้ง',
		'1.png'				=> 'นายธีรพัฒน์ โสนเส้ง'
	);
	$imgList = array(); $i = 1;
	$imgList[] = array(
			'text'	=> "eiei",
			'value'	=> "eiei",
			'selected'	=> false,
			'imageSrc'	=> "https://scontent-a-sin.xx.fbcdn.net/hphotos-xfp1/t1.0-9/10471017_654014221358068_3364417760663383265_n.jpg",
			'description'	=> '[]'
			);
	foreach (glob("{$imgFolder}/*.{jpg,jpeg,gif,png,webp}", GLOB_BRACE) as $file){
		$fileName = htmlspecialchars(basename($file));
		$imgList[$i] = array(
			'text'	=> $fileName,
			'value'	=> $fileName,
			'selected'	=> false,
			'imageSrc'	=> $file,
			'description'	=> '[]'
			);
		if(isset($creator[$fileName])){
			$imgList[$i]['description'] = $creator[$fileName];
		}
		$i++;
	}
	if(isset($_GET['get-img-list'])) :
		header('Content-Type: application/json');
		echo json_encode($imgList);
	else :
?><!DOCTYPE html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>jQuery UI Example Page</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/ui-lightness/jquery-ui-1.10.4.css" rel="stylesheet">
	<link href="css/chosen.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/switch-checkbox.css">
	<style type="text/css">
		html, body{
			min-height: 450px;
			min-width: 900px;
		}
		#slide-zone.gradientTop{
			z-index: 9999;
			background-color: rgb(255, 255, 255);
			width: 100%;
			padding-left: 0;
			padding-right: 0;
		}
		#slide-zone.gradientTop:after{
			position: absolute;
			left: 0;
			bottom: -20px;
			width: 100%;
			height: 20px;
			content: ' ';
			background: -moz-linear-gradient(top,  rgba(255,255,255,1) 25%, rgba(255,255,255,0.5) 75%, rgba(255,255,255,0) 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(25%,rgba(255,255,255,1)), color-stop(75%,rgba(255,255,255,0.5)), color-stop(100%,rgba(255,255,255,0)));
			background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 25%,rgba(255,255,255,0.5) 75%,rgba(255,255,255,0) 100%);
			background: -o-linear-gradient(top,  rgba(255,255,255,1) 25%,rgba(255,255,255,0.5) 75%,rgba(255,255,255,0) 100%);
			background: -ms-linear-gradient(top,  rgba(255,255,255,1) 25%,rgba(255,255,255,0.5) 75%,rgba(255,255,255,0) 100%);
			background: linear-gradient(to bottom,  rgba(255,255,255,1) 25%,rgba(255,255,255,0.5) 75%,rgba(255,255,255,0) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#00ffffff',GradientType=0 );
		}
		#slide-zone #hover-to-slideup{
			display: none;
		}
		#slide-zone.gradientLeft #hover-to-slideup{
			display: block;
		}
		#slide-zone.gradientLeft #result{
			-webkit-transition-property:-webkit-transform; /* Safari and Chrome */
			   -moz-transition-property:   -moz-transform; /* Firefox 4 */
			     -o-transition-property:     -o-transform; /* Opera */
			        transition-property:        transform;
			-webkit-transition-duration: 1s; /* Safari */
			        transition-duration: 1s;
			-webkit-transition-delay: 1s;
			        transition-delay: 1s;
			-webkit-transform: translateY(0);
			        transform: translateY(0);
			z-index: 10000;
		}
		#slide-zone.gradientLeft #result:hover{
			-webkit-transform: translateY(-100%);
			        transform: translateY(-100%);
		}
		#preview{
			width: 800px;
			height: 400px;
			background-image: url("./template/IMG_0720-2.JPG");
			background-size: cover;
			background-repeat: no-repeat;
			overflow: hidden;
		}
		#result{
			width: 800px;
			padding: 0;
		}
		#preview-label, #result-label{
			font-family: 'CmPrasanmit','THSarabunPSK', sans-serif;
			width: 20%;
			font-size: 1.2em;
			color: white;
			background-color: rgba(0,0,0,0.65);
			position: absolute;
			top: 0; 
			padding: 2%;
			padding-top: 0.5%;
			padding-bottom: 0.5%;
			z-index: 7777;
		}
		#preview-label{ left: 0; }
		#result-label{ right: 0; text-align: right; z-index: 10000; }
		#preview .ui-draggable{
			border: solid 1px #00F;
		}
		#school-logo{
			background-image: url("./assets/PCCNST_Logo_border.png");
			background-size: contain;
			background-repeat: no-repeat;
			width: 141px;
			height: 200px;
			left: 25px;
			top: 70px;
		}
		.logo-extended-preview{
			background-size: contain;
			background-repeat: no-repeat;
			position: absolute;
		}
		#headline{
			color: #1e2166;
			font-family: 'ThaiSans Neue','LillyUPC','THSarabunPSK', sans-serif;
			font-weight: bolder;
			font-size: 80px;
			line-height: 1;
			-webkit-font-smoothing:antialiased;
			-moz-osx-font-smoothing: grayscale;
			width: 600px;
			top: 50px;
			left: 200px;
			white-space:nowrap;
		}
		#description{
			color: #1e2166;
			font-family: 'CmPrasanmit','THSarabunPSK', sans-serif;
			font-weight: bolder;
			font-size: 40px;
			line-height: 1;
			-webkit-font-smoothing:antialiased;
			-moz-osx-font-smoothing: grayscale;
			width: 600px;
			top: 150px;
			left: 200px;
			white-space:nowrap;
		}
		#credit{
			color: #cb4d03;

			font-family: 'CmPrasanmit','THSarabunPSK', sans-serif;
			font-weight: bold;
			font-size: 20px;
			line-height: 1;
			text-align: right;
			-webkit-font-smoothing:antialiased;
			-moz-osx-font-smoothing: grayscale;
			width: 780px;
			position: absolute;
			bottom: 10px;
			left: 0;
			white-space:nowrap;
		}
		#backgroundImage .dd-select{
			background: inherit;
		}
		#backgroundImage .dd-select:before{
			content: ' ';
			position: absolute;
			right: 0;
			top: 0;
			width: 20px;
			height: 100%;
			background: inherit;
		}
		#backgroundImage .dd-selected-image, #backgroundImage .dd-option-image{
			max-width: 175px;
		}
		#descriptionFontFamily{
			width: 100%;
		}
		#descriptionFontFamily_chosen, #creditFontFamily_chosen{
			font-size: 1.2em;
		}
		@media screen and (-webkit-min-device-pixel-ratio: 0) {
		  #headline {
		    /*text-shadow: none;
		    -webkit-text-stroke: 5px white;*/
		  }
		}
	</style>
</head>
<body>
	<div class="container-fluid" id="slide-zone">
		<div class="row">
			<div class="center-block" style="max-width: 1600px;">
				<div class="col-md-6" id="preview">
					<div id="preview-label">ภาพตัวอย่าง</div>
					<div id="school-logo"> </div>
					<div id="headline" style="position:absolute;">พิมพ์ข้อความในช่องครับ</div>
					<div id="description" style="position:absolute;">พิมพ์ข้อความในช่องครับ</div>
					<div id="credit">จัดทำสไลด์โดย<span id="slideCreator">นายราชศักดิ์ รักษ์กำเนิด</span> ภาพพื้นหลังโดย<span id="photographer"></span></div>
				</div>
				<div class="col-md-6" id="result">
					<div id="result-label">ภาพจริง<div id="hover-to-slideup">Tip: ชี้เมาส์ค้างไว้อย่างน้อย 1 วินาที ภาพจะเลื่อนขึ้นมาให้เห็นทั้งหมด</div></div>
					<canvas width="800" height="400" id="canvas-result"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="container" id="control-zone">
		<form role="form" id="cover-config">
			<div class="row">
				<fieldset class="col-md-6">
					<legend>รูปพื้นหลัง</legend>
					<div class="col-md-6 form-group">
						<label for="backgroundImage">เลือกรูปภาพ</label>
						<select class="form-control" id="backgroundImage">
						<?php foreach ($imgList AS $imgValue): ?>
							<option value="<?php echo $imgValue['value']; ?>" data-imagesrc="<?php echo $imgValue['imageSrc']; ?>"<?php if(isset($imgValue['description'])): ?> data-description="<?php echo $imgValue['description']; ?>"<?php endif ;?>><?php echo $imgValue['text']; ?></option>
						<?php endforeach; ?>
						</select>
					</div>

				</fieldset>			
				<fieldset class="col-md-6">
					<legend>โลโก้เพิ่มเติม</legend>
					<div class="col-md-6 form-group">
						<label for="logoExtended">เลือกรูปภาพ</label>
						<input type="file" id="logoExtended" />
					</div>
					<div class="col-md-6" id="logo-extended-list"></div>

				</fieldset>	
				<fieldset class="col-md-6">
					<legend>หัวเรื่อง</legend>
					<div class="form-group">
						<label for="headlineText">ข้อความหัวเรื่อง (พิมพ์ \n เพื่อขึ้นบรรทัดใหม่)</label>
						<input type="text" class="form-control" id="headlineText" placeholder="พิมพ์ข้อความที่ต้องการ" value="สวัสดี">
					</div>
					<div class="form-group">
						<label for="headlineFontSize">ขนาดอักษร : <span id="headlineFontSizeValue">80</span></label>
						<div id="headlineFontSize"></div>
					</div>
					<div class="form-group">
						<label for="headlineLineHeight">ระยะห่างระหว่างบรรทัด : <span id="headlineLineHeightValue">1</span></label>
						<div id="headlineLineHeight"></div>
					</div>
				</fieldset>
				<fieldset class="col-md-6">
					<legend>คำอธิบาย</legend>
					<div class="form-group">
						<label for="descriptionText">ข้อความคำอธิบาย (พิมพ์ \n เพื่อขึ้นบรรทัดใหม่)</label>
						<input type="text" class="form-control" id="descriptionText" placeholder="พิมพ์ข้อความที่ต้องการ" value="สวัสดีครับผม">
					</div>
					<div class="form-group">
						<label for="descriptionFontSize">ขนาดอักษร : <span id="descriptionFontSizeValue">40</span></label>
						<div id="descriptionFontSize"></div>
					</div>
					<div class="form-group">
						<label for="descriptionLineHeight">ระยะห่างระหว่างบรรทัด : <span id="descriptionLineHeightValue">1</span></label>
						<div id="descriptionLineHeight"></div>
					</div>
					<div class="form-group">
						<label for="descriptionFontFamily">แบบอักษรคำอธิบาย : </label>
						<select id="descriptionFontFamily" class="chosen-select form-control">
							<option style="font-family: 'THSarabunPSK';">THSarabunPSK</option>
							<option style="font-family: 'TH Sarabun New';">TH Sarabun New</option>
							<option style="font-family: 'CmPrasanmit';">CmPrasanmit</option>
							<option style="font-family: 'ThaiSans Neue';">ThaiSans Neue</option>
							<option style="font-family: 'LilyUPC';">LilyUPC</option>
							<option style="font-family: 'FreesiaUPC';">FreesiaUPC</option>
						</select>
					</div>
					<div class="form-group">
						<label for="descriptionMathStroke"> ใช้การคำนวนทางคณิตศาสตร์แทนการสร้างขอบอักษรแบบ Native (ขอบจะมน แต่อักษรจะหยาบกว่า)</label>
						<div class="onoffswitch">
							<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="descriptionMathStroke" checked>
							<label class="onoffswitch-label" for="descriptionMathStroke">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</fieldset>
				<fieldset class="col-md-12">
					<legend>เครดิต</legend>
					<div class="form-group">
						<label for="slideCreatorText">ผู้ทำสไลด์</label>
						<input type="text" class="form-control" id="slideCreatorText" placeholder="พิมพ์ข้อความที่ต้องการ" value="นายราชศักดิ์ รักษ์กำเนิด">
					</div>
					<div class="form-group">
						<label for="photographerText">ที่มาภาพถ่าย</label>
						<input type="text" class="form-control" id="photographerText" placeholder="พิมพ์ข้อความที่ต้องการ" value="นายธีรพัฒน์ โสนเส้ง">
					</div>
					<div class="form-group">
						<label for="creditFontSize">ขนาดอักษร : <span id="creditFontSizeValue">20</span></label>
						<div id="creditFontSize"></div>
					</div>
					<div class="form-group">
						<label for="creditFontFamily">แบบอักษรเครดิต : </label>
						<select id="creditFontFamily" class="chosen-select form-control">
							<option style="font-family: 'THSarabunPSK';">THSarabunPSK</option>
							<option style="font-family: 'TH Sarabun New';">TH Sarabun New</option>
							<option style="font-family: 'CmPrasanmit';">CmPrasanmit</option>
							<option style="font-family: 'ThaiSans Neue';">ThaiSans Neue</option>
							<option style="font-family: 'LilyUPC';">LilyUPC</option>
							<option style="font-family: 'FreesiaUPC';">FreesiaUPC</option>
						</select>
					</div>
					<div class="form-group">
						<label for="creditMathStroke"> ใช้การคำนวนทางคณิตศาสตร์แทนการสร้างขอบอักษรแบบ Native (ขอบจะมน แต่อักษรจะหยาบกว่า)</label>
						<div class="onoffswitch">
							<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="creditMathStroke" checked>
							<label class="onoffswitch-label" for="creditMathStroke">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="row">
				<div class="center-block col-md-3">
					<button type="submit" class="btn btn-primary btn-lg" id="submitDraw">ส่งออก</button> 
					<button type="button" class="btn btn-primary btn-lg canvassaver" data-toggle="modal" data-target="#save-local-prompt" id="saveCanvas">บันทึกภาพ</button>
				</div>
			</div>
		</form>
	</div>
	<!-- Modal Save To Local-->
	<div class="modal fade" id="save-local-prompt" tabindex="-1" role="dialog" aria-labelledby="save-local-prompt-head" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="save-local-prompt-head">บันทึกลงเครื่องเราเอง</h4>
				</div>
				<form id="save-local-form" role="form">
					<div class="modal-body">
						<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
							<input type="text" class="form-control" placeholder="File name" id="save-local-filename">
						</div>
						<div class="form-group">
							<label for="save-local-tinypng"> ใช้การเพิ่มประสิทธิภาพไฟล์ด้วย TinyPNG (อาจต้องรอนานกว่าเดิมเล็กน้อยขณะติดต่อ server หากทำไม่สำเร็จระบบจะยังคืนภาพเดิมให้ตามปกติ)</label>
							<div class="onoffswitch">
								<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="save-local-tinypng" checked>
								<label class="onoffswitch-label" for="save-local-tinypng">
									<span class="onoffswitch-inner"></span>
									<span class="onoffswitch-switch"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
						<button type="submit" class="btn btn-primary" id="save-local-submit">บันทึก!</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-ui-1.10.4.js"></script>
	<script src="js/chosen.jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.ddslick.min.js"></script>
	<script src="js/jquery-textstroke.js"></script>
	<script type="text/javascript" src="js/canvassaver.js"></script>
	<script type="text/javascript">
	var canvas, ctx, canvasSaveObj, pos, logoImg, headlineImg, headlineImgWidth, headlineImgHeight, headlineCoverHeight, headlineCoverWidth, headlineLineHeight = 1, headlineColor, descriptionLineHeight = 1, descriptionColor, creditColor, textX, textY, textSize, textMsg, logoExtendedImg = {}, logoExtendedImgCnt = -1;
	var firstTime = true;
	function stickySlideZone(){
		var slideZone = $("#slide-zone");
		var slideZoneHeight = slideZone.height();
		var previewWidth = $("#preview").outerWidth(true);
		if($(window).width() < previewWidth * 1.25){
			$("#control-zone").css({
					"margin-left": "",
					"margin-top": ""
				}).width("");
			slideZone.css({
				"position":"",
				"left": "",
				"top": ""
			}).removeClass("gradientTop").removeClass("gradientLeft");;
		}
		else{
			$("#plz-mor-wide").hide();
			slideZone.css({
				"position":"fixed",
				"left": 0,
				"top": 0
			});		
			if(slideZoneHeight < $(window).height()){
				//adjsut control bottom
				$("#control-zone").css({
					"margin-left":"",
					"margin-top":slideZoneHeight+15
				}).width("");
				slideZone.addClass("gradientTop").removeClass("gradientLeft");
			} else{
				//adjsut control right
				$("#control-zone").css({
					"margin-left":previewWidth,
					"margin-top": ""
				}).width($(window).width() - previewWidth - 15);
				slideZone.removeClass("gradientTop").addClass("gradientLeft");
			}
		}
		var optionHeight = $(window).height() - $("#backgroundImage").offset().top - $("#backgroundImage").height(); console.log(optionHeight);
		
		$("#backgroundImage ul.dd-options").css({
			'max-height':optionHeight,
			"overflow-y": "scroll"
		});
	};

	function selectImageByDDSlick(selectedObj){
		//set height for dd-options
		var optionHeight = $(window).height() - $("#backgroundImage").offset().top - $("#backgroundImage").height(); 
		$("#backgroundImage .dd-options").css({
			'max-height':optionHeight,
			"overflow-y": "scroll"
		});
		$("#preview").css("background-image", "url('"+selectedObj.selectedData.imageSrc+"')");
		if(selectedObj.selectedData.description.length>0 || selectedObj.selectedData.description=='[]'){
			$("#photographerText").val(selectedObj.selectedData.description);
			$("#photographerText").attr("readonly", true);
		}else{
			$("#photographerText").attr("readonly", false);
		}
	};
	
	function strokeTextCanvas(text, colorStroke, r, stX, stY, haveShadow, shadowColor){
		var steps = 48;
		if(haveShadow){
			ctx.shadowColor = shadowColor;
			ctx.fillText(text, stX+(r/2), stY+(r/2));
		}
		ctx.shadowColor = "rgba(0,0,0,0)";
		ctx.fillStyle = colorStroke;
		for (var t=0;t<=(2*Math.PI);t+=(2*Math.PI)/steps){
			var x = r*Math.cos(t);
			var y = r*Math.sin(t);
			x = (Math.abs(x) < 1e-6) ? 0 : x;
			y = (Math.abs(y) < 1e-6) ? 0 : y;
			ctx.fillText(text, stX+x, stY+y);
		}
	};

	function regenBackgroundImage(){
		if(typeof $('#backgroundImage').data('ddslick') !== "undefined") 
			$('#backgroundImage').ddslick('destroy');
		$('#backgroundImage').html('');
		$.getJSON(window.location.pathname, {'get-img-list': parseInt(Math.random()*1000000000) }, function(data){
			$('#backgroundImage').ddslick({
				'data': data,
				width: '100%',
				onSelected: function(selectedObj){
					selectImageByDDSlick(selectedObj);
				}
			});
		});
	};

	/*extend logo*/
	function createObjectURL(object) {
	    return (window.URL) ? window.URL.createObjectURL(object) : window.webkitURL.createObjectURL(object);
	}

	function revokeObjectURL(url) {
	    return (window.URL) ? window.URL.revokeObjectURL(url) : window.webkitURL.revokeObjectURL(url);
	}

	
	function generateCanvas(){
		/*set text same*/
		$("#headline").html($("#headlineText").val().replace(/\\n/g, "<br>"));
		$("#description").html($("#descriptionText").val().replace(/\\n/g, "<br>"));
		$("#slideCreator").html($("#slideCreatorText").val());
		$("#photographer").html($("#photographerText").val());
		/*set font same*/
		$("#descriptionFontFamily_chosen .chosen-single, #description").css("font-family", $("#descriptionFontFamily").val());
		$("#creditFontFamily_chosen .chosen-single, #credit").css("font-family", $("#creditFontFamily").val());
		/* background*/
		headlineImg = new Image();
		headlineImg.src = $("#preview").css('background-image').replace('url(','').replace(')','');
		/* logo 1/2 */
		logoImg = new Image();
		logoImg.src = $("#school-logo").css('background-image').replace('url(','').replace(')','');

		//ctx.clearRect (0,0,800,400);
		ctx.fillText("กำลังโหลดภาพ", 0, 0);
		headlineImg.onload = function(){
			logoImg.onload = function(){
				ctx.textAlign="start";
				ctx.clearRect (0,0,800,400);
				headlineImgHeight = headlineImg.height;
				headlineImgWidth = headlineImg.width;
				if((headlineImgHeight*2) > headlineImgHeight){
					headlineCoverWidth = headlineImgWidth;
					headlineCoverHeight = parseInt(headlineImgWidth/2);
				} else{
					headlineCoverWidth = parseInt(headlineImgHeight/2);
					headlineCoverHeight = headlineImgHeight;
				}
				ctx.drawImage(headlineImg,0,0,headlineCoverWidth,headlineCoverHeight,0,0,800,400);
				/* logo 2/2 */
				pos = $("#school-logo").position();
				ctx.drawImage(logoImg,0,0,logoImg.width,logoImg.height,pos.left,pos.top,$("#school-logo").width(),$("#school-logo").height());
				/*extended image*/
				$.each(logoExtendedImg, function(index, img){
					//console.log(img);
					var logoExtendedPreviewSelector = $(".logo-extended-preview[data-logono='"+img.logono+"']")
					var pos = logoExtendedPreviewSelector.position();
					//console.log(logoExtendedPreviewSelector);
					ctx.drawImage(img,0,0,img.width,img.height,pos.left,pos.top,logoExtendedPreviewSelector.width(),logoExtendedPreviewSelector.height());
				});
				/* headline text*/
				headlineColor = $("#headline").css("color");
				ctx.font = "bolder "+$("#headline").css("font-size")+' "ThaiSans Neue"';
				ctx.strokeStyle = 'white';
				ctx.lineWidth=10;
				ctx.fillStyle = headlineColor;
				pos = $("#headline").position();
				textSize = parseInt($("#headline").css("font-size"));
				textX = parseInt(pos.left); textY = parseInt(pos.top+(textSize*0.85));
				text = $("#headlineText").val();
				$.each(text.split("\\n"), function(i, lineText){
					ctx.shadowOffsetX = 4;
					ctx.shadowOffsetY = 4;
					ctx.shadowBlur = 4;
					ctx.shadowColor = "rgba(0,0,0,0.5)";
					ctx.strokeText(lineText.trim(), textX, textY);

					ctx.shadowOffsetX = 0;
					ctx.shadowOffsetY = 0;
					ctx.shadowBlur = 1;
					ctx.shadowColor = headlineColor.replace(")", ", 0.1)");
					ctx.fillText(lineText.trim(), textX, textY);
					textY += parseInt(textSize * headlineLineHeight);
				});
				/* description text*/
				descriptionColor = $("#description").css("color");
				ctx.font = "bolder "+$("#description").css("font-size")+' '+$("#description").css("font-family");

				pos = $("#description").position();
				textSize = parseInt($("#description").css("font-size"));
				textX = parseInt(pos.left); textY = parseInt(pos.top+(textSize*0.85));
				text = $("#descriptionText").val();
				ctx.strokeStyle = 'white';
				ctx.lineWidth=6;
				$.each(text.split("\\n"), function(i, lineText){
					ctx.shadowColor = "rgba(0,0,0,0.5)";
					ctx.shadowBlur = 4;
					ctx.shadowOffsetX = 4;
					ctx.shadowOffsetY = 4;
					if($("#descriptionMathStroke").is(':checked')){
						strokeTextCanvas(lineText.trim(), 'white', 3, textX, textY, true, "rgba(0,0,0,0.8)"); //fill real border
					}
					else{							
						ctx.strokeText(lineText.trim(), textX, textY);
					}
					ctx.fillStyle = descriptionColor;
					ctx.shadowOffsetX = 0;
					ctx.shadowOffsetY = 0;
					ctx.shadowBlur = 1;
					ctx.shadowColor = descriptionColor.replace(")", ", 0.1)");
					ctx.fillText(lineText.trim(), textX, textY);
					textY += parseInt(textSize * descriptionLineHeight);
				});
				/* credit text*/
				ctx.textAlign="end";
				creditColor = $("#credit").css("color");
				ctx.font = "bolder "+$("#credit").css("font-size")+' '+$("#credit").css("font-family");

				pos = $("#credit").position();
				textSize = parseInt($("#credit").css("font-size"));
				textX = 780; textY = 400 - (textSize*0.75);
				text = $("#credit").text();
				ctx.strokeStyle = 'white';
				ctx.lineWidth = 6;
				ctx.shadowColor = "rgba(0,0,0,0.5)";
				ctx.shadowBlur = 2;
				ctx.shadowOffsetX = 2;
				ctx.shadowOffsetY = 2;
				if($("#creditMathStroke").is(':checked')){
					strokeTextCanvas(text.trim(), 'white', 3, textX, textY, true, "rgba(0,0,0,0.8)"); //fill real border
				}
				else{							
					ctx.strokeText(text.trim(), textX, textY);
				}
				ctx.fillStyle = creditColor;
				ctx.shadowOffsetX = 0;
				ctx.shadowOffsetY = 0;
				ctx.shadowBlur = 1;
				ctx.shadowColor = creditColor.replace(")", ", 0.1)");
				ctx.fillText(text.trim(), textX, textY);
			};
		};
	}

	$(function() {
		stickySlideZone();
		$(window).resize(function(){
			stickySlideZone();
		});
		/* <canvas> */
		canvas = $('#canvas-result')[0];
		ctx = canvas.getContext('2d');
		canvasSaveObj = new CanvasSaver('./saveImg.php');
		/** splash screen **/
		var grd=ctx.createLinearGradient(0,0,0,400);
		grd.addColorStop(0,"rgba(30,87,153,1)");
		grd.addColorStop(0.50,"rgba(41,137,216,1)");
		grd.addColorStop(0.51,"rgba(32,124,202,1)");
		grd.addColorStop(1,"rgba(125,185,232,1)");
		ctx.fillStyle=grd;
		ctx.fillRect(0,0,800,400);
		textX = 20; textY = 60;
		ctx.shadowColor = "black"; ctx.shadowOffsetX = 3; ctx.shadowOffsetY = 3; ctx.shadowBlur = 0;
		ctx.fillStyle = "white";
		ctx.font = "bolder 40px 'ThaiSans Neue'";
		ctx.fillText("ระบบสร้างสไลด์ด้วย canvas สำหรับเว็บไซต์ Version 0.1 alpha", textX, textY);
		textY += 10;
		ctx.beginPath();
		ctx.moveTo(textX,textY);
		ctx.lineTo(790,textY);
		ctx.strokeStyle = "white";
		ctx.lineWidth = 6;
		ctx.stroke();
		textY += 18+15;
		ctx.font = "bold 30px 'CmPrasanmit'";
		ctx.fillText("วิธีการใช้งาน", textX, textY);
		ctx.shadowColor = "transparent";
		ctx.font = "normal 25px 'CmPrasanmit'";
		textY += 30; ctx.fillText("ภาพด้านซ้ายสำหรับการแก้ไข เช่นลาก/ขยายขนาด กล่องขวา(กล่องนี้)จะเป็นภาพจริง", textX, textY);
		textY += 30; ctx.fillText("1. เลือกรูปภาพจาก select box ตามต้องการ", textX, textY);
		textY += 30; ctx.fillText("2. แก้ไขข้อมูลให้เป็นไปตามต้องการจากกล่องด้านล่าง", textX, textY);
		textY += 30; ctx.fillText("3. ลากกล่องข้อความ (กล่องที่เลื่อนได้จะมีกรอบสีน้ำเงินกำกับ) ไปยังตำแหน่งที่ต้องการ", textX, textY);
		textY += 30; ctx.fillText("4. หากต้องการย่อโลโก้ สามารถยืดขยายได้ที่มุมล่างขวาของโลโก้ (ระบบจะรักษาสัดส่วนโลโก้ให้อัตโนมัติ)", textX, textY);
		textY += 30; ctx.fillText("5. เมื่อปรับจนพอใจแล้ว ให้กดปุ่ม \"ส่งออก\" หรือ enter ที่ช่องแก้ไขข้อความเพื่อดูภาพที่ได้จริง", textX, textY);
		textY += 30; ctx.fillText("6. เมื่อได้ดังต้องการแล้ว ให้กด \"บันทึก\" หรือ \"ส่งขึ้น server\" จะมีป๊อปอัพขึ้นมา ให้ใส่ข้อมูลลงไปตามที่ระบบ", textX, textY);
		textY += 30; ctx.fillText("   ร้องขอ แล้วกด \"ยืนยัน!\" เพื่อบันทึกภาพหรือส่งเข้า server พร้อมสำหรับเขียนบทความ", textX, textY);
		ctx.shadowColor = "black"; ctx.shadowOffsetX = 2; ctx.shadowOffsetY = 2;
		ctx.font = "bold 40px 'CmPrasanmit'";
		textY += 40; ctx.fillText("Made with \u2665 by Rachasak Ragkamnerd.", textX, textY);
		textX += 625; textY -= 10;
		ctx.shadowColor = "transparent";
		ctx.font = "bold 20px 'CmPrasanmit'"; 
		ctx.fillText(" CC     BY:", textX, textY);
		ctx.font = "bold 40px 'CmPrasanmit'"; 
		ctx.fillText("        $", textX+5, textY+2);
		ctx.beginPath();
		ctx.arc(textX+15,textY-5,20,0,2*Math.PI);
		ctx.strokeStyle = "white";
		ctx.lineWidth = 3;
		ctx.stroke();
		ctx.beginPath();
		ctx.arc(textX+65,textY-5,20,0,2*Math.PI);
		ctx.strokeStyle = "white";
		ctx.lineWidth = 3;
		ctx.stroke();
		ctx.beginPath();
		ctx.arc(textX+110,textY-5,20,0,2*Math.PI);
		ctx.strokeStyle = "white";
		ctx.lineWidth = 3;
		ctx.stroke();
		ctx.beginPath();
		ctx.moveTo(textX+95,textY-18);
		ctx.lineTo(textX+128,textY+5);
		ctx.strokeStyle = "white";
		ctx.lineWidth = 3;
		ctx.stroke();
		/* </canvas> */
		/* <backgroundImage> */		
		$('#backgroundImage').ddslick({
			width: '100%',
			onSelected: function(selectedObj){
				selectImageByDDSlick(selectedObj);
				if(!firstTime) generateCanvas();
				else firstTime = false;
			}
		});
		/* </backgroundImage> */
		/*<extendlogo>*/
		$('#logoExtended').change(function(){
			if(this.files.length) {
				for(var i in this.files){
					if(this.files.hasOwnProperty(i)){
						logoExtendedImgCnt++;
						var src = createObjectURL(this.files[i]);
						var image = new Image();
						image.onload = function(){
							image.logono = logoExtendedImgCnt;
							logoExtendedImg[logoExtendedImgCnt] = image;
							var delButtonObj = $('<button type="button" class="btn btn-danger del-logo col-md-6">ลบ</button>')
								.on('click', function(){
									var logono = $(this).parent().data("logono");
									delete logoExtendedImg[logono];
									$(".logo-extended-preview[data-logono='"+logono+"']")
										.draggable("destroy")
										.resizable("destroy")
										.remove();
									$(this).parent().remove();
									generateCanvas();
								});
							$('<div class="row logo-extended" id="logo-extended-'+logoExtendedImgCnt+'"data-logono='+logoExtendedImgCnt+'></div>')
								.append(delButtonObj)
								.append('<img src="'+image.src+'" class="col-md-6" style="max-height: 200px;"/>')
								.appendTo("#logo-extended-list");
							$(this).val('');
							/*add image into preview*/
							var ratio = image.width / image.height, logoWidth, logoHeight;
							if(ratio>=1){
								logoWidth = (image.width<= 250)?image.width*ratio:250*ratio;
								logoHeight = (image.width<= 250)?image.width:250;
							}else{
								logoWidth = (image.height<= 250)?image.height:250;
								logoHeight = (image.height<= 250)?image.height*ratio:250*ratio;
							}
							$('<div class="logo-extended-preview" data-logono="'+logoExtendedImgCnt+'"></div>')
								.css({
									"width": logoWidth,
									"height" : logoHeight,
									"background-image" : "url('"+image.src+"')"
								})
								.appendTo("#preview")
								.draggable({ 
									/*containment: "#preview",*/
									drag: function(event, ui){
										generateCanvas();
									}
								})
								.resizable({
									aspectRatio: ratio,
									resize: function(event, ui){
										generateCanvas();
									}
								});
							};
							image.src = src;
					}
					// Do whatever you want with your image, it's just like any other image
					// but it displays directly from the user machine, not the server!
				}
			}
		});
		/*</extendlogo>*/
		/* <schoolLogo> */
		$("#school-logo").draggable({ 
			containment: "#preview",
			drag: function(event, ui){
				generateCanvas();
			}
		}).resizable({
			aspectRatio: 484/700,
			resize: function(event, ui){
				generateCanvas();
			}
		});
		/* </schoolLogo> */
		/* <headline> */
		$("#headline").draggable({
			drag: function(event, ui){
				ui.helper.width(ui.helper.parent().width() - ui.position.left);
				generateCanvas();
			}
		});
		$("#headline").textStroke(5, "#FFF", "8px 8px 7px rgba(0,0,0,0.5)");
		$("#headlineText").keyup(function(){
			$("#headline").html($(this).val().replace(/\\n/g, "<br>"));
		});
		$("#headlineFontSize").slider({ 
			min: 25,
			max: 150,
			value: 80,
			slide: function(event, ui){
				$("#headline").css("font-size", ui.value);
				$("#headlineFontSizeValue").text(ui.value);
				generateCanvas();
			}
		});
		$("#headlineLineHeight").slider({ 
			min: 25,
			max: 200,
			value: 100,
			slide: function(event, ui){
				$("#headline").css("line-height", ui.value/100);
				$("#headlineLineHeightValue").text(ui.value/100);
				headlineLineHeight = ui.value/100;
				generateCanvas();
			}
		});
		/* </headline> */
		/* <description> */
		$("#description").draggable({
			drag: function(event, ui){
				ui.helper.width(ui.helper.parent().width() - ui.position.left);
				generateCanvas();
			}
		});
		$("#description").textStroke(3, "#FFF", "4px 4px 3px rgba(0,0,0,0.5)");
		$("#descriptionText").keyup(function(){
			$("#description").html($(this).val().replace(/\\n/g, "<br>"));
		});
		$("#descriptionFontSize").slider({ 
			min: 12,
			max: 80,
			value: 40,
			slide: function(event, ui){
				$("#description").css("font-size", ui.value);
				$("#descriptionFontSizeValue").text(ui.value);
				generateCanvas();
			}
		});
		$("#descriptionLineHeight").slider({ 
			min: 25,
			max: 200,
			value: 100,
			slide: function(event, ui){
				$("#description").css("line-height", ui.value/100);
				$("#descriptionLineHeightValue").text(ui.value/100);
				descriptionLineHeight = ui.value/100;
				generateCanvas();
			}
		});
		$("#descriptionFontFamily").chosen({width:"inherit"});
		$('#descriptionFontFamily').on('change chosen:ready', function(evt, params) {
			$("#descriptionFontFamily_chosen .chosen-single, #description").css("font-family", $(this).val());
		});
		/* </description> */
		/* <credit> */
		/*$("#credit").draggable({
			drag: function(event, ui){
				ui.helper.width(ui.helper.parent().width() - ui.position.left);
			}
		});*/
		$("#credit").textStroke(2, "#FFF", "4px 4px 3px rgba(0,0,0,0.5), 0px 0px 20px rgba(255, 255, 153, 1)");
		$("#slideCreatorText").keyup(function(){
			$("#slideCreator").html($(this).val());
		});
		$("#photographerText").keyup(function(){
			$("#photographer").html($(this).val());
		});
		$("#creditFontSize").slider({ 
			min: 12,
			max: 45,
			value: 20,
			slide: function(event, ui){
				$("#credit").css("font-size", ui.value);
				$("#creditFontSizeValue").text(ui.value);
			}
		});
		$("#creditFontFamily").chosen({width:"inherit"});
		$('#creditFontFamily').on('change chosen:ready', function(evt, params) {
			$("#creditFontFamily_chosen .chosen-single, #credit").css("font-family", $(this).val());
		});
		/* </credit> */
		$("#cover-config").submit(function(e){
			e.preventDefault();
			generateCanvas();
		});
		$("#save-local-form").submit(function(e){
			e.preventDefault();
			var fname = $("#save-local-filename").val();
			if(!fname.length){
				fname = "slide";
				$("#save-local-filename").val(fname);
			}
			canvasSaveObj.savePNG(canvas, fname, $("#save-local-tinypng").is(":checked"));
			$('#save-local-prompt').modal('hide');
		});	
	});
	</script>
</body>
</html>
<!-- http://proto.io/freebies/onoff/ -->
<?php endif;