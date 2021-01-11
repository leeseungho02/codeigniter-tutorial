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
                <td><?= $post->content ?></td>
                <td><?= $post->create_dt ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="uk-flex uk-flex-center">
    <?= $this->pagination->create_links(); ?>
</div>