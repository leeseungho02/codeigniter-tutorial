<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form method="POST" class="form uk-form-stacked">
        <input type="hidden" name="id" value="<?= $this->session->userdata('member')->id ?>">
        <input type="hidden" name="prev_pw" value="<?= $this->session->userdata('member')->pw ?>">
        <input type="hidden" name="email" value="<?= $this->session->userdata('member')->email; ?>" readonly />

        <div class="uk-margin-bottom">
            <label class="uk-form-label">비밀번호</label>
            <div class="uk-form-controls">
                <input type="password" name="pw" id="pw" placeholder="변경할 비밀번호를 입력해주세요." class="uk-input" value="">
                <?= form_error("pw", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">비밀번호 확인</label>
            <div class="uk-form-controls">
                <input type="password" name="pw_check" id="pw_check" placeholder="한 번 더 입력해주세요." class="uk-input">
                <?= form_error("pw_check", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">이름</label>
            <div class="uk-form-controls">
                <input type="text" name="name" id="name" placeholder="이름을 입력해주세요." class="uk-input" value="<?= $this->session->userdata('member')->name; ?>" />
                <?= form_error("name", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <button type="button" id="postcodify_search_button" class="uk-button uk-button-default uk-margin-bottom">주소검색</button>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">우편번호</label>
            <div class="uk-form-controls">
                <input type="text" name="postcodify_postcode5" class="uk-input postcodify_postcode5" value="<?= $this->session->userdata('member')->postcodify_postcode5; ?>" />
                <?= form_error("postcodify_postcode5", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">도로명주소</label>
            <div class="uk-form-controls">
                <input type="text" name="postcodify_address" class="uk-input postcodify_address" value="<?= $this->session->userdata('member')->postcodify_address; ?>" />
                <?= form_error("postcodify_address", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">상세주소</label>
            <div class="uk-form-controls">
                <input type="text" name="postcodify_details" class="uk-input postcodify_details" value="<?= $this->session->userdata('member')->postcodify_details; ?>" />
                <?= form_error("postcodify_details", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>
        </div>

        <div class="uk-margin-bottom">
            <label class="uk-form-label">참고항목</label>
            <div class="uk-form-controls">
                <input type="text" name="postcodify_extra_info" class="uk-input postcodify_extra_info" value="<?= $this->session->userdata('member')->postcodify_extra_info; ?>" />
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

        <div class="uk-flex uk-flex-right uk-flex-middle">
            <button type="submit" class="uk-button uk-button-default">회원수정</button>
        </div>

    </form>

</div>