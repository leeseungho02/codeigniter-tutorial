<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form method="POST" class="form uk-form-stacked">

        <div class="uk-margin-bottom">
            <label class="uk-form-label">이메일</label>
            <div class="uk-form-controls">
                <input type="email" name="email" id="email" placeholder="이메일을 입력해주세요." class="uk-input" value="<?= set_value('email'); ?>">
                <?= form_error("email", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">비밀번호</label>
            <div class="uk-form-controls">
                <input type="password" name="pw" id="pw" placeholder="비밀번호를 입력해주세요." class="uk-input" value="<?= set_value('pw'); ?>">
                <?= form_error("pw", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">이름</label>
            <div class="uk-form-controls">
                <input type="text" name="name" id="name" placeholder="이름을 입력해주세요." class="uk-input" value="<?= set_value('name'); ?>">
                <?= form_error("name", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <button type="button" id="postcodify_search_button" class="uk-button uk-button-default uk-margin-bottom">주소검색</button>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">우편번호</label>
            <div class="uk-form-controls">
                <input type="text" name="postcodify_postcode5" class="uk-input postcodify_postcode5" value="" />
                <?= form_error("postcodify_postcode5", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">도로명주소</label>
            <div class="uk-form-controls">
                <input type="text" name="postcodify_address" class="uk-input postcodify_address" value="" />
                <?= form_error("postcodify_address", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">상세주소</label>
            <div class="uk-form-controls">
                <input type="text" name="postcodify_details" class="uk-input postcodify_details" value="" />
                <?= form_error("postcodify_details", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">참고항목</label>
            <div class="uk-form-controls">
                <input type="text" name="postcodify_extra_info" class="uk-input postcodify_extra_info" value="" />
                <?= form_error("postcodify_extra_info", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <!-- jQuery와 Postcodify를 로딩한다 -->
        <script src="/assets/js/search.min.js"></script>

        <!-- "검색" 단추를 누르면 팝업 레이어가 열리도록 설정한다 -->
        <script>
            $(function() {
                $("#postcodify_search_button").postcodifyPopUp();
            });
        </script>

        <div class="uk-flex uk-flex-between uk-flex-middle">
            <a href="/index.php/member/login/view" class="passwordFind">이미 계정이 있으신가요?</a>
            <button type="submit" class="uk-button uk-button-default">회원가입</button>
        </div>

    </form>

</div>