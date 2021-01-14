<?php if ($title != "") { ?>
    <div id="modal" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default closeBtn" type="button" uk-close onclick="move('<?= $post->id ?>', <?= isset($list) ? $list : false ?>)"></button>
            <form method="post">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title"><?= $title ?></h2>
                </div>
                <div class="uk-modal-body">
                    <input type="password" name="pw" id="pw" class="uk-input" value="" placeholder="비밀번호를 입력해주세요.">
                    <?= form_error("pw", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close closeBtn" type="button" onclick="move('<?= $post->id ?>', <?= isset($list) ? $list : false ?>)">취소</button>
                    <button class="uk-button uk-button-primary" type="submit">확인</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>

<script>
    const show = "<?= $title ?>";
    if (show != "") {
        showModal('#modal');
    }

    function move(pid, list) {
        let url = list ? `/post` : `/post/view/${pid}`;
        window.location.href = url;
    }
</script>