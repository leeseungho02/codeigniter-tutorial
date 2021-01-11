<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form method="POST" class="form uk-form-stacked" enctype="multipart/form-data">

        <div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">제목</label>
                <div class="uk-form-controls">
                    <input type="title" name="title" id="title" placeholder="제목을 입력해주세요." class="uk-input" value="<?= $title ?>">
                    <?= form_error("title", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">내용</label>
                <div class="uk-form-controls">
                    <textarea name="content" id="content" placeholder="내용을 입력해주세요." class="uk-textarea"><?= $content ?></textarea>
                    <?= form_error("content", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">타입</label>
                <div class="uk-form-controls">
                    <label><input class="uk-radio" type="radio" name="type" value="public" <?= $type == "public" ? "checked" : "" ?>>일반글</label>
                    <label><input class="uk-radio" type="radio" name="type" value="notice" <?= $type == "notice" ? "checked" : "" ?>>공지글</label>
                    <label><input class="uk-radio" type="radio" name="type" value="private" <?= $type == "private" ? "checked" : "" ?>>비밀글</label>
                    <?= form_error("type", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">첨부파일</label>
                <div class="uk-form-controls" uk-form-custom="target: true">
                    <input type="file" name="file">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                </div>
                <?= form_error("file", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>


        </div>

        <div class="uk-flex uk-flex-right uk-flex-middle">
            <button type="reset" class="uk-button uk-button-default uk-margin-right">초기화</button>
            <button type="submit" class="uk-button uk-button-default">글 수정</button>
        </div>

    </form>

</div>