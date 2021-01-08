<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>테스트</title>
	<link rel="stylesheet" href="/assets/css/uikit.min.css">
	<link rel="stylesheet" href="/assets/css/common.css">
	<script src="/assets/js/uikit.min.js"></script>
	<script src="/assets/js/uikit-icons.min.js"></script>
</head>

<body>

	<?php if ($this->session->userdata('member')) { ?>
		<a href="/index.php">메인페이지</a>
		<a href="/index.php/member/mypage/logout">로그아웃</a>
	<?php } ?>

	<div class="messageBox">

		<?php if ($this->session->flashdata("message")) { ?>
			<div class="uk-alert-danger errorMessage" uk-alert>
				<a class="uk-alert-close" uk-close></a>
				<p class="uk-margin-right"><?= $this->session->flashdata("message"); ?></p>
			</div>
		<?php } ?>

	</div>

	<?php
	if ($this->session->flashdata("message")) {
		$this->session->unset_userdata("message");
	}
	?>