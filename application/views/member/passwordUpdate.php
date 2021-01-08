<link rel="stylesheet" href="/assets/css/member.css">


<div class="parentForm">

    <form method="POST" class="form uk-form-stacked">
        <div class="uk-margin-bottom">
            <label class="uk-form-label">새 비밀번호</label>
            <div class="uk-form-controls">
                <input type="password" name="pw" id="pw" placeholder="새 비밀번호를 입력해주세요." class="uk-input">
                <?= form_error("pw", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>
        <div class="uk-margin-bottom">
            <label class="uk-form-label">새 비밀번호 확인</label>
            <div class="uk-form-controls">
                <input type="password" name="pw_check" id="pw_check" placeholder="한 번 더 입력해주세요." class="uk-input">
                <?= form_error("pw_check", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>
        <div class="uk-flex uk-flex-right uk-margin-small-top">
            <a href="/index.php/member/login/view" class="uk-button uk-button-default uk-margin-small-right">취소</a>
            <button type="submit" class="uk-button uk-button-default">비밀번호변경</button>
        </div>
    </form>

</div>