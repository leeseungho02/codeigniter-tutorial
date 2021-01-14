<link rel="stylesheet" href="/assets/css/member.css">

<div class="parentForm">

    <form action="/comment/updateProccess" method="POST" class="form uk-form-stacked" enctype="multipart/form-data">

        <div>

            <input type="hidden" name="id" value="<?= $comment->id ?>">

            <div class="uk-margin-bottom">
                <label class="uk-form-label">내용</label>
                <div class="uk-form-controls">
                    <textarea name="content" id="content" placeholder="내용을 입력해주세요." class="uk-textarea"><?= $comment->content ?></textarea>
                    <?= form_error("content", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

        </div>

        <div class="uk-flex uk-flex-right uk-flex-middle uk-margin-top">
            <button type="reset" class="uk-button uk-button-default uk-margin-right">초기화</button>
            <button type="submit" class="uk-button uk-button-default">댓글 수정</button>
        </div>

    </form>

</div>