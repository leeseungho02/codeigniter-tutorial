<div style="padding: 50px;">
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <div class="uk-text-large">글 제목: <?= $post->title ?></div>
        <div class="uk-flex uk-flex-middle uk-flex-center">
            <small class="uk-margin-small-right">작성날짜: <?= $post->create_dt ?></small>
            <small>조회수: <?= $post->hit ?></small>
        </div>
    </div>
    <div class="uk-margin-top">
        <?= $post->content ?>
    </div>

    <div class="uk-margin-top uk-flex uk-flex-right">
        <a href="/index.php/post/update/<?= $post->id ?>" class="uk-button uk-button-default uk-margin-right">수정</a>
        <a href="/index.php/post/delete/<?= $post->id ?>" class="uk-button uk-button-danger">삭제</a>
    </div>
</div>

<div style="padding: 100px;">

    <form action="/index.php/comment/insert" method="POST" class="form uk-form-stacked">
        <input type="hidden" name="pid" id="pid" value="<?= $post->id ?>">
        <div>

            <div class="uk-margin-bottom">
                <label class="uk-form-label">내용</label>
                <div class="uk-form-controls">
                    <textarea name="content" id="content" placeholder="내용을 입력해주세요." class="uk-textarea"></textarea>
                    <?= form_error("content", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>
            </div>

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

        </div>

        <div class="uk-flex uk-flex-right uk-flex-middle">
            <button type="submit" class="uk-button uk-button-default">댓글 작성</button>
        </div>

    </form>

    <?php foreach ($comments as $key => $comment) { ?>
        <article class="uk-comment uk-margin-bottom">
            <header class="uk-comment-header">
                <div class="uk-grid-medium uk-flex-middle" uk-grid>
                    <div class="uk-width-expand">
                        <h4 class="uk-comment-title uk-margin-remove"><?= $comment->name ? $comment->name : $comment->non_member_id ?></h4>
                        <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                            <li><a href="#"><?= $comment->create_dt ?></a></li>
                        </ul>
                    </div>
                </div>
            </header>
            <div class="uk-comment-body">
                <p><?= $comment->content ?></p>
            </div>

            <div class="uk-margin-top">
                <a href="/index.php/comment/update/<?= $comment->id ?>" class="uk-button uk-button-default uk-margin-right">수정</a>
                <a href="/index.php/comment/delete/<?= $comment->id ?>" class="uk-button uk-button-danger">삭제</a>
            </div>

        </article>
    <?php } ?>

</div>