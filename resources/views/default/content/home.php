<main class="col-span-7 mb-col-12">
  <div class="box-flex-white relative">
    <ul class="nav">

      <?= tabs_nav(
        'nav',
        $data['sheet'],
        $user,
        $pages = [
          [
            'id'    => $data['type'] . '.feed',
            'url'   => '/',
            'title' => Translate::get('feed'),
            'icon'  => 'bi bi-sort-down'
          ], [
            'tl'    => 1,
            'id'    => $data['type'] . '.all',
            'url'   => getUrlByName('main.all'),
            'title' => Translate::get('all'),
            'icon'  => 'bi bi-app'
          ], [
            'id'    => $data['type'] . '.top',
            'url'   => getUrlByName('main.top'),
            'title' => Translate::get('top'),
            'icon'  => 'bi bi-bar-chart'
          ], [
            'tl'    => 9,
            'id'    => $data['type'] . '.deleted',
            'url'   => getUrlByName('main.deleted'),
            'title' => Translate::get('deleted'),
            'icon'  => 'bi bi-bar-chart'
          ],
        ]
      ); ?>

    </ul>

    <div class="trigger">
      <i class="bi bi-info-square gray-400"></i>
    </div>
    <div class="dropdown tooltip"><?= Translate::get($data['sheet'] . '.info'); ?></div>

  </div>

  <?= Tpl::import('/content/post/post', ['data' => $data, 'user' => $user]); ?>

  <div class="mb15">
    <?= pagination($data['pNum'], $data['pagesCount'], $data['sheet'], null); ?>
  </div>
</main>

<aside class="col-span-3 mb-none">
  <?php if ($user['id'] == 0) { ?>
    <?= Tpl::import('/_block/sidebar/login', ['user' => $user]); ?>
  <?php } ?>

  <?php if ($user['id'] > 0 && !empty($data['topics_user'])) { ?>
    <div class="box-white text-sm">
      <h3 class="uppercase-box"><?= Translate::get('reading'); ?></h3>
      <ul>
        <?php
        $my = [];
        $other = [];
        foreach ($data['topics_user'] as $topic) {
          if ($topic['facet_user_id'] == $user['id']) {
            $my[] = $topic;
          } else {
            $other[] = $topic;
          }
        }
        $topics = array_merge($my, $other);
        $n = 0;
        foreach ($topics as $key => $topic) {
          $n++;
          if ($n > Config::get('facets.quantity_home')) break;
          $url = getUrlByName('topic', ['slug' => $topic['facet_slug']]);
          $blog = '';
          if ($topic['facet_type'] == 'blog') {
            $blog = '<sup class="red-500">b</span>';
            $url = getUrlByName('blog', ['slug' => $topic['facet_slug']]);
          }
        ?>
          <li class="mb10">
            <a href="<?= $url; ?>">
              <?= facet_logo_img($topic['facet_img'], 'max', $topic['facet_title'], 'img-base'); ?>
              <span class="ml5 middle"><?= $topic['facet_title']; ?> <?= $blog; ?></span>
            </a>
            <?php if ($user['id'] == $topic['facet_user_id']) { ?>
              <a class="right gray-400 mt5" title="<?= sprintf(Translate::get('add.option'), Translate::get('post')); ?>" href="<?= getUrlByName('content.add', ['type' => 'post']); ?>/<?= $topic['facet_id']; ?>">
                <i class="bi bi-plus-lg text-sm"></i>
              </a>
            <?php } ?>
          </li>
        <?php } ?>
      </ul>
      <?php if (count($data['topics_user']) > Config::get('facets.quantity_home')) { ?>
        <a class="gray-400 block mt5" title="<?= Translate::get('topics'); ?>" href="<?= getUrlByName('topics.my'); ?>">
          <?= Translate::get('see more'); ?> <i class="bi bi-chevron-double-right middle"></i>
        </a>
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="box-white text-sm">
      <h3 class="uppercase-box"><?= Translate::get('topics'); ?></h3>
      <?php foreach (Config::get('facets.default') as $key => $topic) { ?>
        <a class="flex items-center relative pb10 gray-600" href="<?= $topic['url']; ?>">
          <img class="img-base" src="<?= $topic['img']; ?>" alt="<?= $topic['name']; ?>">
          <?= $topic['name']; ?>
        </a>
      <?php } ?>
    </div>
  <?php } ?>

  <div class="sticky top-sm">
    <?php if (!empty($data['latest_answers'])) { ?>
      <div class="box-white">
        <ul class="last-content">
          <?php foreach ($data['latest_answers'] as $answer) { ?>
            <li>
              <a title="<?= $answer['login']; ?>" href="<?= getUrlByName('profile', ['login' => $answer['login']]); ?>">
                <?= user_avatar_img($answer['avatar'], 'small', $answer['login'], 'ava-sm'); ?>
              </a>
              <span class="middle lowercase gray-400"><?= $answer['answer_date']; ?></span>
              <a class="last-content_telo" href="<?= getUrlByName('post', ['id' => $answer['post_id'], 'slug' => $answer['post_slug']]); ?>#answer_<?= $answer['answer_id']; ?>">
                <?= $answer['answer_content']; ?>...
              </a>
            </li>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>
  </div>
</aside>