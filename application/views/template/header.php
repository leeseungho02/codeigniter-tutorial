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

	<div id="header">

		<a href="/index.php/post">글 목록</a>
		<a href="/index.php/post/insert">글작성</a>

		<?php if ($this->session->userdata('member')) { ?>
			<a href="/index.php/member/mypage/update">회원수정</a>
			<a href="/index.php/member/mypage/delete">회원탈퇴</a>
			<a href="/index.php/member/mypage/logout">로그아웃</a>
		<?php } ?>

	</div>

	<?php if ($this->session->flashdata("message")) { ?>
		<div class="uk-alert-<?= $this->session->flashdata("message_type") ?> message" uk-alert>
			<a class="uk-alert-close" uk-close></a>	
			<p class="uk-margin-right"><?= $this->session->flashdata("message"); ?></p>
		</div>
	<?php } ?>

	<?php
	if ($this->session->flashdata("message")) {
		$this->session->unset_userdata("message");
		$this->session->unset_userdata("message_type");
	}
	?>

	<script>
		if (document.querySelector(".message")) {
			setTimeout(() => {
				document.querySelector(".message").classList.add("hide");
			}, 5000);
		}
	</script>