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

    <div>
        <?php foreach ($files as $key => $file) { ?>
            <a href="/uploads/<?= $file->name ?>" download="<?= $file->original_name ?>">
                <img data-src="/uploads/<?= $file->name ?>" alt="a" uk-img>
            </a>
        <?php } ?>
    </div>

    <div class="uk-margin-top uk-flex uk-flex-right">
        <a href="/post" class="uk-button uk-button-default uk-margin-right">목록</a>
        <a href="/post/insert/<?= $post->id ?>" class="uk-button uk-button-default uk-margin-right">답글작성</a>
        <a href="#" data-writer="<?= $post->writer ?>" data-url="/post/update/<?= $post->id ?>" class="uk-button uk-button-default uk-margin-right postLink">수정</a>
        <a href="#" data-writer="<?= $post->writer ?>" data-url="/post/delete/<?= $post->id ?>" class="uk-button uk-button-danger postLink">삭제</a>
    </div>
</div>

<div style="padding: 100px;">

    <form action="/comment/insert" method="POST" class="form uk-form-stacked">
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
                        <input type="text" name="non_member_id" id="non_member_id" placeholder="비회원 아이디를 입력해주세요." class="uk-input"></input>
                        <?= form_error("non_member_id", '<div class="error uk-margin-small-top">', '</div>') ?>
                    </div>
                </div>
                <div class="uk-margin-bottom">
                    <label class="uk-form-label">비회원 비밀번호</label>
                    <div class="uk-form-controls">
                        <input type="password" name="non_member_pw" id="non_member_pw" placeholder="비회원 비밀번호를 입력해주세요." class="uk-input"></input>
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

            <div class="view">
                <div class="uk-comment-body">
                    <p><?= $comment->content ?></p>
                </div>

                <div class="uk-margin-top">
                    <a href="#" class="uk-button uk-button-default uk-margin-right commentUpdateLink" data-writer="<?= $comment->writer ?>">수정</a>
                    <a href="#" class="uk-button uk-button-danger commentDeleteLink" data-writer="<?= $comment->writer ?>"
                    data-url="/comment/delete/<?= $comment->id ?>">삭제</a>
                </div>
            </div>

            <form action="/comment/update" method="POST" class="form uk-form-stacked d-none">
                <input type="hidden" name="id" value="<?= $comment->id ?>">
                <div class="uk-margin-bottom">
                    <label class="uk-form-label">내용</label>
                    <div class="uk-form-controls">
                        <input type="text" name="content" id="content" class="uk-input" value="<?= $comment->content ?>">
                        <?= form_error("content", '<div class="error uk-margin-small-top">', '</div>') ?>
                    </div>
                </div>
                <div class="uk-flex uk-flex-right uk-flex-middle">
                    <button type="submit" class="uk-button uk-button-default">글 수정</button>
                </div>
            </form>

        </article>
    <?php } ?>

</div>

<div id="modal" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <form>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">비회원 비밀번호 확인</h2>
            </div>
            <div class="uk-modal-body">
                <input type="hidden" name="table" id="table" value="posts">
                <input type="password" name="pw" id="pw" class="uk-input" value="" placeholder="비밀번호를 입력해주세요.">
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">취소</button>
                <button class="uk-button uk-button-primary" type="submit">확인</button>
            </div>
        </form>
    </div>
</div>

<script>
    const member = <?= json_encode($this->session->userdata('member')) ?>;
</script>
<script src="/assets/js/postView.js"></script>