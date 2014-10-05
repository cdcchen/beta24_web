<?php

/* @var $this yii\web\View */
/* @var $question common\models\Question */
/* @var $answers array|common\models\Answer[] */
?>

<?php foreach ($answers as $answer):?>
    <a name="answer-<?= $answer->id ?>"></a>
    <div class="answer clearfix">
        <div class="vote-cell">
            <a class="bg-icons vote-up-off" href="#">支持</a>
            <span class="vote-count"><?= $answer->vote_up ?></span>
            <a class="bg-icons vote-down-off" href="#">反对</a>
<!--            <a class="bg-icons vote-accepted-off" href="#">最佳答案</a>-->
        </div>
        <div class="post-cell clearfix">
            <div class="post-content"><?= $answer->getPurifyContent() ?></div>
            <div class="share-box">
                <a href="#">分享</a>
            </div>
            <div class="post-userinfo <?= $answer->userIsOwner ? 'owner' : '' ?>">
                <div class="action-time">answered：<?= $answer->createdAt ?></div>
                <a class="gravatar gravatar32 pull-left" href="<?= $answer->user->getHomeUrl() ?>" target="_blank">
                    <?= $answer->user->profile->getGavatarImg(32) ?>
                </a>
                <div class="detail">
                    <a href="<?= $answer->user->getHomeUrl() ?>" target="_blank">
                        <?=$answer->user->getDisplayName() ?>
                    </a>
                    <br />
                    <span>10</span>
                    <span>20</span>
                </div>
            </div>
        </div>

        <?php if (count($answer->comments) > 0):?>
            <ul class="comments clearfix" id="">
                <?php foreach ($answer->comments as $c):?>
                    <li>
                        <?= hencode($c->content) ?>
                        <a href="<?= $c->user->homeUrl ?>" class="user"><?= $c->user->displayName ?></a>
                        <span class="datetime"><?= $c->createdAt ?></span>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php endif;?>
        <div class="comments-link clearfix">
            <a class="new-comment" href="#">添加评论</a>
        </div>
    </div>
<?php endforeach;?>