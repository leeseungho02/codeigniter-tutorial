<div class="uk-padding">

    <div class="uk-flex uk-flex-right uk-margin">

        <form method="POST" class="form uk-form-stacked">

            <div class="uk-flex uk-flex-middle uk-margin-right">

                <div class="uk-margin-right" uk-form-custom="target: > * > span:first-child">
                    <select name="type">
                        <option <?= $type == "title" ? " selected" : "" ?> value="title">제목</option>
                        <option <?= $type == "writer" ? " selected" : "" ?> value="writer">작성자</option>
                    </select>
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">
                        <span></span>
                        <span uk-icon="icon: chevron-down"></span>
                    </button>
                </div>

                <div class="uk-form-controls uk-margin-right">
                    <input type="text" name="keyword" placeholder="검색어를 입력해주세요." class="uk-input" value="<?= $keyword ?>" />
                    <?= form_error("title", '<div class="error uk-margin-small-top">', '</div>') ?>
                </div>

                <button type="submit" class="uk-button uk-button-default">검색</button>

            </div>

        </form>

    </div>
    
    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
            <tr>
                <th>글 번호</th>
                <th>제목</th>
                <th>작성날짜</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $key => $post) { ?>
                <tr>
                    <td>
                        <?= ($currentNumber - $key) ?>
                    </td>
                    <td>
                        <a href="/post/view/<?= $post->id ?>" data-url="/post/view/<?= $post->id ?>" class="<?= $post->type == "private" ? "privateLink" : "" ?>">
                            <?php for ($i = 0; $i < $post->depth; $i++) {  ?>
                                &nbsp; RE:
                            <?php } ?>
                            <?php if ($post->pdelete) { ?>
                                삭제된 글입니다.
                            <?php } else { ?>
                                <?= $post->title ?>
                            <?php } ?>
                            <?php if ($post->type == "private") { ?>
                                <img src="/assets/images/private_icon.png" alt="" width="25">
                            <?php } ?>
                        </a>
                    </td>
                    <td><?= $post->create_dt ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="uk-flex uk-flex-center">
    <?= $this->pagination->create_links(); ?>
</div>

<div id="modal" uk-modal>
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <form>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">비밀글 비밀번호 확인</h2>
            </div>
            <div class="uk-modal-body">
                <input type="hidden" name="table" value="posts">
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
    document.querySelectorAll(".privateLink").forEach(el => {
        el.addEventListener("click", (e) => {
            const target = e.currentTarget;
            const url = target.dataset.url;
            e.preventDefault();
            showModal('#modal');
            const form = document.querySelector('#modal form');
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                ajax("/post/writerCheck", "POST", formData, function(data) {
                    data = JSON.parse(data);
                    if (data) {
                        window.location.href = url;
                    } else {
                        alert("비밀번호가 틀리셨습니다.");
                    }
                });
            });
        });
    });
</script>