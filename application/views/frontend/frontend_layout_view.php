<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo $titlePage; ?></title>
    <meta name="description" content="Phân tích kèo bóng đá, tỷ lệ cá cược bóng đá Anh, Cup C1 , TBN, Đức, tip bóng đá miễn phí chính xác hôm nay." />
	<meta name="keywords" content="keo bong da, keo bong da hom nay, tip bong da, tip bong da mien phi, ty le bong da, ty le ca cuoc bong da" />
	<meta name="news_keywords" content="keo bong da, keo bong da hom nay, tip bong da, tip bong da mien phi, ty le bong da, ty le ca cuoc bong da" />
	 <link rel="icon" href="<?php echo base_url() ?>public/frontend/images/favicon.ico">
	<link rel="canonical" href="<?php echo base_url() ?>" />
	<link rel="stylesheet" href="<?php echo base_url('public/frontend/css/style.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('public/frontend/css/own_style.css') ?>">
	<script type="text/javascript" src="<?php echo base_url() ?>public/frontend/js/jquery-1.12.1.min.js"></script>
</head>
<body>
	<center>
		<div id="container">
			<div class="ALL">
				<div class="Header">
					<div class="Header_menu">
						<a id="pc_menu" class="icon_menu">
							<img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-menu.png">
						</a>
					</div>
					<a href="<?php echo base_url() ?>" style="display: block; height: 40px;">
						<!-- <img width="127px" src="http://ale.vn/images/bong-da-logo-mobiphone_1.png"> -->
					</a>
					<div class="Header_Timkiem">
						<a href="javascript:void(0);"><img src="<?php echo base_url() ?>public/frontend/images/search.png"></a>
					</div>
					<div class="searchWrapper">
						<form id="searchForm" method="post" action="<?php echo base_url('tim-kiem.html') ?>">
							<input type="text" name="keyword" id="txtSeach" placeholder="Nhập từ khóa tìm kiếm" value="" onkeypress="if(event.keyCode === 13) {document.getElementById('searchButton').click();return false;}">
							<input type="submit" id="searchButton" value="Tìm kiếm" style="display: block;width: 100.6%;height: 35px;
							color: #14a7e4;text-transform: uppercase;font-size: 14px;
							cursor: pointer;font-weight: bold; margin-bottom: 10px;">
						</form>
						<script>
							$(document).ready(function () {
								$('.Header_Timkiem').click(function () {
									$('.searchWrapper').slideToggle("fast");
								});
							});
						</script>
					</div>
				</div>
				<div class="Menu_left_bg" id="topmenu" style="display: none;">
					<div class="Menu_Left_list">
						<ul>
							<li><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-list-menutrai.gif" style="padding-right:8px;">TRANG CHỦ</a></li>
							<li><a href="<?php echo base_url() ?>tin-tuc-bong-da.html"><img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-list-menutrai.gif" style="padding-right:8px;">ĐIỂM TIN</a></li>
							<li><a href="<?php echo base_url() ?>nhan-dinh-bong-da.html"><img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-list-menutrai.gif" style="padding-right:8px;">NHẬN ĐỊNH</a></li>
							<li><a href="<?php echo base_url() ?>tip.html"><img src="<?php echo base_url() ?>public/frontend/images/bong-da-icon-list-menutrai.gif" style="padding-right:8px;">Tip</a></li>
						</ul>
					</div>

				</div>
				<div class="MenuHeader" id="menu">
					<ul>
						<li><a href="<?php echo base_url() ?>">Trang chủ</a></li>
						<li><a href="<?php echo base_url() ?>nhan-dinh-bong-da.html">Nhận định</a></li>
						<li><a href="<?php echo base_url() ?>tin-tuc-bong-da.html">Điểm tin</a></li>
						<li><a href="<?php echo base_url() ?>tip.html">Tip</a></li>
					</ul>
					<div class="both"></div>
				</div>
				<div class="Main" id="page">
					<?php $this->load->view($loadPage); ?>
					<div class="Footer">
						© Copyright 2018 - DCV <br>
					</div>
				</div>
			</div>
		</div>
	</center>
	<script type="text/javascript" src="<?php echo base_url() ?>public/frontend/js/app.js"></script>
	</body>
</html>