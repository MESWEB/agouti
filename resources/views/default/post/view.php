<?php $post = $data['post']; ?>
<main class="col-span-9 mb-col-12">
  <article class="post-full border-box-1 br-rd5 bg-white<?php if ($post['post_is_deleted'] == 1) { ?> bg-red-300<?php } ?> mb15 pt0 pr5 pb5 pl15">
    <?php if ($post['post_is_deleted'] == 0 || $uid['user_trust_level'] == 5) { ?>
      <div class="post-body">
        <h1 class="title mb0 size-24">
          <?= $post['post_title']; ?>
          <?php if ($post['post_is_deleted'] == 1) { ?>
            <i class="bi bi-trash blue"></i>
          <?php } ?>
          <?php if ($post['post_closed'] == 1) { ?>
            <i class="bi bi-lock gray"></i>
          <?php } ?>
          <?php if ($post['post_top'] == 1) { ?>
            <i class="bi bi-pin-angle blue"></i>
          <?php } ?>
          <?php if ($post['post_lo'] > 0) { ?>
            <i class="bi bi-award blue"></i>
          <?php } ?>
          <?php if ($post['post_type'] == 1) { ?>
            <i class="bi bi-patch-question green"></i>
          <?php } ?>
          <?php if ($post['post_translation'] == 1) { ?>
            <span class="pt5 pr10 pb5 pl10 gray-light bg-yellow-100 br-rd3 size-14 italic lowercase">
              <?= lang('translation'); ?>
            </span>
          <?php } ?>
          <?php if ($post['post_tl'] > 0) { ?>
            <span class="pt5 pr10 pb5 pl10 gray-light bg-orange-100 br-rd3 italic size-14">
              tl<?= $post['post_tl']; ?>
            </span>
          <?php } ?>
          <?php if ($post['post_merged_id'] > 0) { ?>
            <i class="link-link-ext blue"></i>
          <?php } ?>
        </h1>
        <div class="size-14 lowercase flex gray-light-2">
          <a class="gray" href="<?= getUrlByName('user', ['login' => $post['user_login']]); ?>">
            <?= user_avatar_img($post['user_avatar'], 'small', $post['user_login'], 'w18'); ?>
            <span class="mr5 ml5">
              <?= $post['user_login']; ?>
            </span>
          </a>
          <span class="blue mr10 ml5"><i class="bi bi-mic size-14"></i></span>
          <?= $post['post_date_lang']; ?>
          <?php if ($post['modified']) { ?>
            (<?= lang('ed'); ?>)
          <?php } ?>

          <?php if ($uid['user_id']) { ?>
            <?php if ($uid['user_login'] == $post['user_login']  || $uid['user_trust_level'] == 5) { ?>
              <a class="gray-light mr10 ml10" href="/post/edit/<?= $post['post_id']; ?>">
                <?= lang('edit'); ?>
              </a>
            <?php } ?>
            <?php if ($uid['user_login'] == $post['user_login']) { ?>
              <?php if ($post['post_draft'] == 0) { ?>
                <?php if ($post['user_my_post'] == $post['post_id']) { ?>
                  <span class="mu_post gray-light mr10 ml10">+ <?= lang('in-the-profile'); ?></span>
                <?php } else { ?>
                  <a class="add-post-profile gray-light mr10 ml10" data-post="<?= $post['post_id']; ?>">
                    <span class="mu_post"><?= lang('in-the-profile'); ?></span>
                  </a>
                <?php } ?>
              <?php } ?>
            <?php } ?>
            <?php if ($uid['user_trust_level'] == 5) { ?>
              <a data-type="post" data-id="<?= $post['post_id']; ?>" class="type-action gray-light mr10 ml10">
                <?php if ($post['post_is_deleted'] == 1) { ?>
                  <i class="bi bi-trash red"></i>
                <?php } else { ?>
                  <i class="bi bi-trash"></i>
                <?php } ?>
              </a>
              <a data-id="<?= $post['post_id']; ?>" class="post-recommend gray-light mr10 ml10">
                <?php if ($post['post_is_recommend'] == 1) { ?>
                  <i class="bi bi-lightning blue"></i>
                <?php } else { ?>
                  <i class="bi bi-lightning"></i>
                <?php } ?>
              </a>
              <span class="size-14 mr5 ml10">
                <?= $post['post_hits_count']; ?>
              </span>
            <?php } ?>
            <?= includeTemplate('/_block/show-ip', ['ip' => $post['post_ip'], 'user_trust_level' => $uid['user_trust_level']]); ?>
          <?php } ?>
        </div>
      </div>

      <?php if ($post['post_thumb_img']) { ?>
        <?= post_img($post['post_thumb_img'], $post['post_title'],  'thumb right ml15', 'thumbnails'); ?>
      <?php } ?>

      <div class="post-body max-w780 full">
        <div class="post">
          <?= $post['post_content']; ?>
        </div>
        <?php if ($post['post_url_domain']) { ?>
          <div class="mb15">
            <a rel="nofollow noreferrer ugc" target="_blank" class="button br-rd5 white" href="<?= $post['post_url']; ?>">
              <?= lang('details are here'); ?> <i class="bi bi-folder-symlink ml5"></i>
            </a>
          </div>
        <?php } ?>
        <?php if ($post['post_url_domain']) { ?>
          <h3 class="uppercase mb5 mt0 font-light size-14 gray"><?= lang('website'); ?></h3>
          <div class="italic m15 mb15 p10 size-14 bg-gray-100 table gray">
            <div>
              <i class="bi bi-link-45deg"></i>
              <a class="gray" href="<?= getUrlByName('domain', ['domain' => $post['post_url_domain']]); ?>">
                <?= $post['post_url_domain']; ?>
              </a>
            </div>
          </div>
        <?php } ?>
        <?= includeTemplate('/_block/post-related', ['post_related' => $data['post_related']]); ?>
        <?php if (!empty($data['topics'])) { ?>
          <div class="mb20">
            <h3 class="uppercase mb5 mt0 font-light size-14 gray"><?= lang('topics'); ?>:</h3>
            <?php foreach ($data['topics'] as $topic) { ?>
              <a class="bg-blue-100 bg-hover-green white-hover flex justify-center pt5 pr10 pb5 pl10 br-rd20 blue inline size-14" href="<?= getUrlByName('topic', ['slug' => $topic['topic_slug']]); ?>">
                <?= $topic['topic_title']; ?>
              </a>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <div class="border-bottom flex flex-row items-center justify-between mb5 pb5 pt10">
        <div class="flex flex-row items-center">
          <?= votes($uid['user_id'], $post, 'post'); ?>
        </div>
        <div class="flex flex-row items-center">
          <?= favorite_post($uid['user_id'], $post['post_id'], $post['favorite_tid']); ?>
        </div>
      </div>
      <div class="hidden">
        <?php if ($uid['user_id'] > 0) { ?>
          <?php if (is_array($data['post_signed'])) { ?>
            <div data-id="<?= $post['post_id']; ?>" data-type="post" class="focus-id size-14 right mt5 bg-gray-100 gray-light-2 border-box-1 br-rd20 center pt5 pr15 pb5 pl15">
              <?= lang('unsubscribe'); ?>
            </div>
          <?php } else { ?>
            <div data-id="<?= $post['post_id']; ?>" data-type="post" class="focus-id size-14 right mt5 bg-gray-200 bg-hover-gray mazarine border-box-1 br-rd20 center pt5 pr15 pb5 pl15">
              + <?= lang('read'); ?>
            </div>
          <?php } ?>
        <?php } else { ?>
          <a class="right size-14 mt5 bg-gray-200 bg-hover-gray mazarine border-box-1 br-rd20 center pt5 pr15 pb5 pl15" href="<?= getUrlByName('login'); ?>">
            + <?= lang('read'); ?>
          </a>
        <?php } ?>
      </div>
      <?= includeTemplate('/_block/editor/answer-create-editor', ['data' => $post, 'type' => 'answer', 'user_id' => $uid['user_id']]); ?>
    <?php } else { ?>
      <div class="bg-red-300 p15 center mr10">
        <?= lang('post deleted'); ?>...
      </div>
    <?php } ?>
  </article>

  <?php if ($post['post_draft'] == 0) {
    if ($post['post_type'] == 0) {
      includeTemplate('/_block/comments-view', ['data' => $data, 'post' => $post, 'uid' => $uid]);
      if ($post['post_closed'] == 1) includeTemplate('/_block/no-content', ['lang' => 'the post is closed']);
    } else {
      includeTemplate('/_block/questions-view', ['data' => $data, 'post' => $post, 'uid' => $uid]);
      if ($post['post_closed'] == 1) includeTemplate('/_block/no-content', ['lang' => 'the question is closed']);
    }
  } else {
    includeTemplate('/_block/no-content', ['lang' => 'this is a draft']);
  } ?>
</main>
<aside class="col-span-3 relative br-rd5 no-mob">
  <div class="border-box-1 bg-white br-rd5 mb15 p15">
    <?php if (!empty($data['topics'])) { ?>
      <h3 class="uppercase mb5 mt0 font-light size-15 gray"><?= lang('topics'); ?></h3>
      <?php foreach ($data['topics'] as $topic) { ?>
        <?php if ($uid['user_id']) { ?>
          <?php if (!$topic['signed_topic_id']) { ?>
            <div data-id="<?= $topic['topic_id']; ?>" data-type="topic" class="focus-id right inline size-14 blue center mt5 mr5">
              <i class="bi bi-plus"></i> <?= lang('read'); ?>
            </div>
          <?php } ?>
        <?php } ?>
        <a class="flex justify-center pt5 pr10 pb5 black  inline size-14" href="<?= getUrlByName('topic', ['slug' => $topic['topic_slug']]); ?>">
          <?= topic_logo_img($topic['topic_img'], 'max', $topic['topic_title'], 'w24 mr10 border-box-1'); ?>
          <?= $topic['topic_title']; ?>
          <div class="gray-light-2 size-14"><?= $topic['topic_short_description']; ?></div>
        </a>
      <?php } ?>
    <?php } ?>
  </div>
  <?php if ($post['post_content_img']) { ?>
    <div class="border-box-1 bg-white br-rd5 mb15">
      <div id="layer-photos" class="layer-photos p15">
        <?= post_img($post['post_content_img'], $post['post_title'], 'w-100 br-rd5', 'cover', $post['post_content_img']); ?>
      </div>
    </div>
  <?php } ?>
  <div class="border-box-1 bg-white br-rd5 mb15 p15">
    <div class="social center" data-url="<?= Config::get('meta.url') . getUrlByName('post', ['id' => $post['post_id'], 'slug' => $post['post_slug']]); ?>" data-title="<?= $post['post_title']; ?>">
      <a class="size-21 pl15 pr15 gray-light-2" data-id="fb"><i class="bi bi-facebook"></i></a>
      <a class="size-21 pl15 pr15 gray-light-2" data-id="vk">VK</a>
      <a class="size-21 pl15 pr15 gray-light-2" data-id="tw"><i class="bi bi-twitter"></i></a>
    </div>
  </div>
  <?php if ($data['recommend']) { ?>
    <div class="border-box-1 bg-white br-rd5 mb15 post-view sticky recommend p15">
      <h3 class="uppercase mb10 mt0 font-light size-14 gray"><?= lang('recommended'); ?></h3>
      <?php foreach ($data['recommend'] as  $rec_post) { ?>
        <div class="mb15 hidden flex">
          <a class="gray size-15" href="<?= getUrlByName('post', ['id' => $rec_post['post_id'], 'slug' => $rec_post['post_slug']]); ?>">
            <?php if ($rec_post['post_answers_count'] > 0) { ?>
              <div class="p5 pr10 pb5 pl10 bg-green-400 br-rd3 white size-14 center mr15">
                <?= $rec_post['post_answers_count'] ?>
              </div>
            <?php } else { ?>
              <div class="p5 pr10 pb5 pl10 bg-gray-300 br-rd3 gray size-14 center mr15">0</div>
            <?php } ?>
          </a>
          <a class="black size-14" href="<?= getUrlByName('post', ['id' => $rec_post['post_id'], 'slug' => $rec_post['post_slug']]); ?>">
            <?= $rec_post['post_title']; ?>
          </a>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
</aside>
<script nonce="<?= $_SERVER['nonce']; ?>">
  $(document).ready(function() {
    layer.photos({
      photos: '#layer-photos',
      anim: 4
    });
    $(document).on('click', '.msg-flag', function() {
      let post_id = $(this).data('post_id');
      let content_id = $(this).data('content_id');
      let type = $(this).data('type');
      layer.confirm('<?= lang('does this violate site rules'); ?>?', {
        icon: 5,
        title: '<?= lang('report'); ?>',
        btn: ['<?= lang('yes'); ?>', '<?= lang('No'); ?>']
      }, function(index) {
        $.post('/flag/repost', {
          type,
          post_id,
          content_id
        }, function(str) {
          if (str == 1) {
            layer.msg('<?= lang('flag not included'); ?>!');
            return false;
          }
          layer.msg('<?= lang('thanks'); ?>!');
        });
      });
    });
  });
</script>
<?= includeTemplate('/_block/wide-footer'); ?>