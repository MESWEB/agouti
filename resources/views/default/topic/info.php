<div class="sticky col-span-2 justify-between no-mob">
  <?= includeTemplate('/_block/menu', ['sheet' => $data['sheet'], 'uid' => $uid]); ?>
</div>
<?php $topic = $data['topic']; ?>
<main class="col-span-7 mb-col-12">
  <div class="bg-white br-rd5 border-box-1 pt5 pr15 pb5 mb15 pl15">
    <a class="size-14" title="<?= lang('topics-all'); ?>" href="/topics">
      ← <?= lang('topics'); ?>
    </a>
    <h1 class="topics">
      <a href="<?= getUrlByName('topic', ['slug' => $topic['topic_slug']]); ?>">
        <?= $topic['topic_seo_title']; ?>
      </a>
      <?php if ($uid['user_trust_level'] == 5) { ?>
        <a class="right gray-light" href="/topic/edit/<?= $topic['topic_id']; ?>">
          <i class="bi bi-pencil size-15"></i>
        </a>
      <?php } ?>
    </h1>
    <h3><?= lang('info'); ?></h3>
    <?= $topic['topic_info']; ?>
  </div>

 <?= includeTemplate('/_block/post-related', ['post_related' => $data['post_related']]); ?>

</main>
<aside class="col-span-3 relative no-mob">
  <div class="bg-white br-rd5 border-box-1 p15 mb15 size-15">
    <center>
      <a title="<?= $topic['topic_title']; ?>" href="<?= getUrlByName('topic', ['slug' => $topic['topic_slug']]); ?>">
        <div><?= $topic['topic_title']; ?></div>
        <?= topic_logo_img($topic['topic_img'], 'max', $topic['topic_title'], 'topic-img'); ?>
      </a>
    </center>
    <hr>
    <div class="gray-light">
      <i class="bi bi-calendar-week mr5 middle"></i>
      <span class="middle"><?= $topic['topic_add_date']; ?></span>
    </div>
  </div>

  <?= includeTemplate('/_block/topic-sidebar', ['data' => $data, 'uid' => $uid]); ?>
</aside>
<?= includeTemplate('/_block/wide-footer'); ?>