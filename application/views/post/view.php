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
        <a href="/index.php/post" class="uk-button uk-button-default uk-margin-right">목록</a>
        <a href="/index.php/post/insert/<?= $post->id ?>" class="uk-button uk-button-default uk-margin-right">답글작성</a>
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
                    <a href="#" class="uk-button uk-button-default uk-margin-right updateLink">수정</a>
                    <a href="/index.php/comment/delete/<?= $comment->id ?>" class="uk-button uk-button-danger">삭제</a>
                </div>
            </div>

            <form action="/index.php/comment/update" method="POST" class="form uk-form-stacked d-none">
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

<div id="modal-group-1" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"></h2>
        </div>
        <div class="uk-modal-body">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <a href="#modal-group-2" class="uk-button uk-button-primary" uk-toggle>Next</a>
        </div>
    </div>
</div>

<script>
    const writer = <?= $post->writer ?>;
    const member = <?= json_encode($this->session->userdata('member')) ?>;
    document.querySelectorAll(".updateLink").forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault();

            if (member) {
                // 해당 작성자 회원인지 체크
                if (writer != member.id) {
                    alert("해당 작성자만 수정 삭제 가능합니다.");
                    return;
                }
            } else {
                // 회원이 아닐 때 비회원의 댓글인지 체크
                if (writer == 0) {
                    
                } else {
                    alert("해당 작성자만 수정 삭제 가능합니다.");
                    return;
                }
            }

            const parent = e.currentTarget.parentElement.parentElement.parentElement;
            parent.querySelector(".d-none").classList.remove("d-none");
            parent.querySelector(".view").classList.add("d-none");
        });
    });

    function memberCheck() {

    }
</script>