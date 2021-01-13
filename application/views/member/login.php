<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form method="POST" class="form uk-form-stacked">

        <div>
            <div class="uk-margin-bottom">
                <label class="uk-form-label">이메일</label>
                <div class="uk-form-controls">
                    <input type="email" name="email" id="email" placeholder="이메일을 입력해주세요." class="uk-input">
                    <?= form_error("email", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">비밀번호</label>
                <div class="uk-form-controls">
                    <input type="password" name="pw" id="pw" placeholder="비밀번호를 입력해주세요." class="uk-input">
                    <?= form_error("pw", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <a href="/member/login/passwordFind" class="passwordFind">비밀번호를 잊어버리셨나요?</a>
            </div>
        </div>

        <div class="uk-flex uk-flex-right uk-flex-middle">
            <a href="/member/register/view" class="uk-button uk-button-default uk-margin-right">회원가입</a>
            <button type="submit" class="uk-button uk-button-default">로그인</button>
        </div>

    </form>

</div>