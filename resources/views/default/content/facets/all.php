<main class="col-span-10 mb-col-12">
  <div class="box-white center">
    <h1 class="text-xl"><?= Translate::get($data['sheet']); ?></h1>
    <span class="text-sm gray-600">
      <?= Translate::get($data['sheet'] . '.info'); ?>.
    </span>
  </div>

  <div class="box-flex-white">
    <ul class="nav">

      <?= tabs_nav(
        'nav',
        $data['sheet'],
        $user,
        $pages = [
          [
            'id'    => $data['type'] . 's.all',
            'url'   => getUrlByName($data['type'] . 's.all'),
            'title' => Translate::get('all'),
            'icon'  => 'bi bi-app'
          ],
          [
            'id'    => $data['type'] . 's.new',
            'url'   => getUrlByName($data['type'] . 's.new'),
            'title' => Translate::get('new ones'),
            'icon'  => 'bi bi-sort-up'
          ],
          [
            'tl'    => 1,
            'id'    => $data['type'] . 's.my',
            'url'   => getUrlByName($data['type'] . 's.my'),
            'title' => Translate::get('reading'),
            'icon'  => 'bi bi-check2-square'
          ],
        ]
      );
      ?>

    </ul>
    <?php if ($user['trust_level'] > 1) { ?>
      <p class="m0 text-xl">
        <?php if ($data['type'] == 'blog') { ?>
          <?php if ($data['limit']) { ?>
            <a class="ml15" title="<?= Translate::get('add'); ?>" href="<?= getUrlByName('content.add', ['type' => $data['type']]); ?>">
              <i class="bi bi-plus-lg middle"></i>
            </a>
          <?php } ?>
        <?php } else { ?>
          <?php if (UserData::checkAdmin()) { ?>
            <a class="ml15" title="<?= Translate::get('add'); ?>" href="<?= getUrlByName('content.add', ['type' => $data['type']]); ?>">
              <i class="bi bi-plus-lg middle"></i>
            </a>
          <?php } ?>
        <?php } ?>
      </p>
    <?php } ?>
  </div>

  <div class="box-white">
    <?php if (!empty($data['facets'])) { ?>
      <?php if ($data['type'] == 'blog') { ?>
        <div class="grid grid-cols-1 gap-2">
          <?= Tpl::import('/_block/facet/blog-list-all', ['facets' => $data['facets'], 'user' => $user]); ?>
        </div>
      <?php } else { ?>
        <div class="grid grid-cols-2 mb-grid-cols-1 gap-2">
          <?= Tpl::import('/_block/facet/topic-list-all', ['facets' => $data['facets'], 'user' => $user]); ?>
        </div>
      <?php } ?>
    <?php } else { ?>
      <?= no_content(Translate::get('no.content'), 'bi bi-info-lg'); ?>
    <?php } ?>
  </div>
  <?= pagination($data['pNum'], $data['pagesCount'], $data['sheet'], '/' . $data['type'] . 's'); ?>
</main>