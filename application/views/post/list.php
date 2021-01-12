<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th>글 번호</th>
            <th>내용</th>
            <th>작성날짜</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $key => $post) { ?>
            <tr>
                <td>
                    <a href="/index.php/post/view/<?= $post->id ?>"><?= $key + 1 ?></a>
                </td>
                <td>
                    <?php for ($i = 0; $i < $post->depth; $i++) {  ?>
                        &nbsp; RE:
                    <?php } ?>
                    <?php if ($post->pdelete) { ?>
                        삭제된 글입니다.
                    <?php } else { ?>
                        <?= $post->content ?>
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