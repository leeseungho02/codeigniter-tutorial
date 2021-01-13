<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>테스트</title>
	<link rel="stylesheet" href="/assets/css/uikit.min.css">
	<link rel="stylesheet" href="/assets/css/common.css">
	<script src="/assets/js/uikit.min.js"></script>
	<script src="/assets/js/uikit-icons.min.js"></script>
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/common.js"></script>
</head>

<body>

	<div id="header">

		<nav class="uk-navbar-container uk-padding uk-padding-remove-vertical" uk-navbar>

			<div class="uk-navbar-left">

				<ul class="uk-navbar-nav">
					<li><a href="/">메인페이지</a></li>
					<li><a href="/post">글 목록</a></li>
					<li><a href="/post/insert">글작성</a></li>
				</ul>

			</div>

			<div class="uk-navbar-right">

				<ul class="uk-navbar-nav">
					<?php if ($this->session->userdata('member')) { ?>
						<li><a href="/member/mypage/update">회원수정</a></li>
						<li><a href="/member/mypage/delete">회원탈퇴</a></li>
						<li><a href="/member/mypage/logout">로그아웃</a></li>
					<?php } else { ?>
						<li><a href="/member/register/view">회원가입</a></li>
						<li><a href="/member/login/view">로그인</a></li>
					<?php } ?>
				</ul>

			</div>

		</nav>

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