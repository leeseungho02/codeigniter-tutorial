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
                    <a href="/index.php/post/view/<?= $post->id ?>"><?= ($currentNumber - $key) ?></a>
                </td>
                <td>
                    <?php for ($i = 0; $i < $post->depth; $i++) {  ?>
                        &nbsp; RE:
                    <?php } ?>
                    <?php if ($post->pdelete) { ?>
                        삭제된 글입니다.
                    <?php } else { ?>
                        <?= $post->title ?>
                    <?php } ?>
                </td>
                <td><?= $post->create_dt ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="uk-flex uk-flex-center">
    <?= $this->pagination->create_links(); ?>
</div>