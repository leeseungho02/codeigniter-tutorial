<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form method="POST" class="form uk-form-stacked" enctype="multipart/form-data">

        <div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">제목</label>
                <div class="uk-form-controls">
                    <input type="text" name="title" id="title" placeholder="제목을 입력해주세요." class="uk-input" value="<?= $post->title ?>">
                    <?= form_error("title", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">내용</label>
                <div class="uk-form-controls">
                    <textarea name="content" id="content" placeholder="내용을 입력해주세요." class="uk-textarea"><?= $post->content ?></textarea>
                    <?= form_error("content", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">타입</label>
                <div class="uk-form-controls">
                    <label><input class="uk-radio" type="radio" name="type" value="public" <?= $post->type == "public" ? "checked" : "" ?>>일반글</label>
                    <label><input class="uk-radio" type="radio" name="type" value="notice" <?= $post->type == "notice" ? "checked" : "" ?>>공지글</label>
                    <label><input class="uk-radio" type="radio" name="type" value="private" <?= $post->type == "private" ? "checked" : "" ?>>비밀글</label>
                    <?= form_error("type", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">첨부파일</label>
                <div class="uk-form-controls" uk-form-custom="target: true">
                    <input type="file" name="userFile" accept="image/*">
                    <input class="uk-input uk-form-width-medium" type="text" placeholder="파일을 선택해주세요." disabled>
                </div>
                <?= form_error("userFile", '<div class="error uk-margin-small-top">', '</div>') ?>
            </div>

            <dl class="uk-description-list uk-description-list-divider">
                <?php foreach ($files as $key => $file) { ?>
                    <dt class="uk-flex uk-flex-between uk-flex-middle">
                        <?= $file->original_name ?>
                        <a href="/post/fileDelete/<?= $file->id ?>" class="uk-button uk-button-default">삭제</a>
                    </dt>
                <?php } ?>
            </dl>


        </div>

        <div class="uk-flex uk-flex-right uk-flex-middle uk-margin-top">
            <button type="reset" class="uk-button uk-button-default uk-margin-right">초기화</button>
            <button type="submit" class="uk-button uk-button-default">글 수정</button>
        </div>

    </form>

</div>

<script>
    createModal("비회원 비밀번호 확인", "posts");
    showModal('#modal');
</script>