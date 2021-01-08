<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form method="POST" class="form uk-form-stacked">
        <div class="uk-margin-bottom">
            <label class="uk-form-label">인증번호</label>
            <div class="uk-form-controls">
                <input type="code" name="code" id="code" placeholder="인증번호를 입력해주세요." class="uk-input" value="">
                <?= form_error("code", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>
        <div class="uk-flex uk-flex-right uk-margin-small-top">
            <button type="submit" class="uk-button uk-button-default">인증하기</button>
        </div>
    </form>

</div>