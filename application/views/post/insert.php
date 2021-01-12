<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form method="POST" class="form uk-form-stacked" enctype="multipart/form-data">

        <div>

            <?php if (!$this->session->userdata('member')) { ?>
                <div class="uk-margin-bottom">
                    <label class="uk-form-label">비회원 아이디</label>
                    <div class="uk-form-controls">
                        <input name="non_member_id" id="non_member_id" placeholder="비회원 아이디를 입력해주세요." class="uk-input"></input>
                        <?= form_error("non_member_id", '<div class="error uk-margin-small-top">', '</div>') ?>
                    </div>
                </div>
                <div class="uk-margin-bottom">
                    <label class="uk-form-label">비회원 비밀번호</label>
                    <div class="uk-form-controls">
                        <input name="non_member_pw" id="non_member_pw" placeholder="비회원 비밀번호를 입력해주세요." class="uk-input"></input>
                        <?= form_error("non_member_pw", '<div class="error uk-margin-small-top">', '</div>') ?>
                    </div>
                </div>
            <?php } ?>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">제목</label>
                <div class="uk-form-controls">
                    <input type="title" name="title" id="title" placeholder="제목을 입력해주세요." class="uk-input">
                    <?= form_error("title", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">내용</label>
                <div class="uk-form-controls">
                    <textarea name="content" id="content" placeholder="내용을 입력해주세요." class="uk-textarea"></textarea>
                    <?= form_error("content", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">타입</label>
                <div class="uk-form-controls">
                    <label><input class="uk-radio" type="radio" name="type" value="public" checked>일반글</label>
                    <label><input class="uk-radio" type="radio" name="type" value="notice">공지글</label>
                    <label><input class="uk-radio" type="radio" name="type" value="private">비밀글</label>
                    <?= form_error("type", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">첨부파일</label>
                <div class="uk-form-controls">
                    <input type="file" name="userFile">
                </div>
                <?= form_error("file", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>


        </div>

        <div class="uk-flex uk-flex-right uk-flex-middle">
            <button type="reset" class="uk-button uk-button-default uk-margin-right">초기화</button>
            <button type="submit" class="uk-button uk-button-default">글 작성</button>
        </div>

    </form>

</div>