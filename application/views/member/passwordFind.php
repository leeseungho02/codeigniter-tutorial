<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form method="POST" class="form uk-form-stacked">
        <div class="uk-margin-bottom">
            <label class="uk-form-label">이메일</label>
            <div class="uk-form-controls">
                <input type="email" name="email" id="email" placeholder="이메일을 입력해주세요." class="uk-input">
                <?= form_error("email", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>
        <div class="uk-flex uk-flex-right uk-margin-small-top">
            <button type="submit" class="uk-button uk-button-default">비밀번호찾기</button>
        </div>
    </form>

</div>