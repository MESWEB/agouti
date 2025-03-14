<?php $n = 0;
foreach ($answer as  $comment) {
  $n++; ?>
  <?php if ($n != 1) { ?><div class="br-top-dotted mt10 mb10"></div><?php } ?>
  <?php if ($comment['comment_is_deleted'] == 1) { ?>
    <?php if (accessСheck($comment, 'comment', $user, 1, 30) === true) { ?>
      <ol class="bg-red-200 text-sm list-none max-w780">
        <li class="pr5" id="comment_<?= $comment['comment_id']; ?>">
          <span class="comm-deletes gray">
            <?= $comment['comment_content']; ?>
            — <?= $comment['login']; ?>
            <a data-type="comment" data-id="<?= $comment['comment_id']; ?>" class="type-action right text-sm">
              <?= Translate::get('recover'); ?>
            </a>
          </span>
        </li>
      </ol>
    <?php } ?>
  <?php } ?>

  <?php if ($comment['comment_is_deleted'] == 0) { ?>
    <ol class="p0 m0 mb15 list-none">
      <li class="comment_subtree" id="comment_<?= $comment['comment_id']; ?>">
          <div class="max-w780">
            <div class="text-sm flex">
              <a class="gray-600" href="<?= getUrlByName('profile', ['login' => $comment['login']]); ?>">
                <?= user_avatar_img($comment['avatar'], 'small', $comment['login'], 'ava-sm'); ?>
                <span class="mr5 ml5">
                  <?= $comment['login']; ?>
                </span>
              </a>
              <?php if ($comment['post_user_id'] == $comment['comment_user_id']) { ?>
                <span class="sky-500 mr5"><i class="bi bi-mic text-sm"></i></span>
              <?php } ?>
              <span class="mr5 ml5 gray-400 lowercase">
                <?= lang_date($comment['comment_date']); ?>
              </span>
              <?= Tpl::import('/_block/show-ip', ['ip' => $comment['comment_ip'], 'user' => $user, 'publ' => $comment['comment_published']]); ?>
            </div>
            <a href="<?= getUrlByName('post', ['id' => $comment['post_id'], 'slug' => $comment['post_slug']]); ?>#comment_<?= $comment['comment_id']; ?>">
              <?= $comment['post_title']; ?>
            </a>
            <div class="mt5 mb10">
              <?= $comment['comment_content']; ?>
            </div>
          </div>
          <div class="text-sm flex">
            <?= votes($user['id'], $comment, 'comment', 'ps', 'mr5'); ?>

            <?php if (accessСheck($comment, 'comment', $user, 1, 30) === true) { ?>
              <a data-post_id="<?= $comment['post_id']; ?>" data-comment_id="<?= $comment['comment_id']; ?>" class="editcomm gray mr10 ml10">
                <?= Translate::get('edit'); ?>
              </a>
              <a data-type="comment" data-id="<?= $comment['comment_id']; ?>" class="type-action gray mr5 ml5">
                <?= Translate::get('remove'); ?>
              </a>
            <?php } ?>

            <?php if ($user['id'] != $comment['comment_user_id'] && $user['trust_level'] > Config::get('trust-levels.tl_stop_report')) { ?>
              <a data-post_id="<?= $comment['post_id']; ?>" data-type="comment" data-content_id="<?= $comment['comment_id']; ?>" class="msg-flag gray-400 ml15">
                <i title="<?= Translate::get('report'); ?>" class="bi bi-flag"></i>
              </a>
            <?php } ?>
          </div>
        <div id="comment_addentry<?= $comment['comment_id']; ?>" class="none"></div>
      </li>
    </ol>
  <?php } ?>
<?php } ?>