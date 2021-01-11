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

<article class="uk-comment">
    <header class="uk-comment-header">
        <div class="uk-grid-medium uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
            </div>
            <div class="uk-width-expand">
                <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#">Author</a></h4>
                <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                    <li><a href="#">12 days ago</a></li>
                    <li><a href="#">Reply</a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="uk-comment-body">
        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
    </div>
</article>