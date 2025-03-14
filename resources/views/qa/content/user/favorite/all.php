<main class="col-span-9 mb-col-12">
  <?= Tpl::import('/content/user/favorite/nav', ['data' => $data, 'user' => $user]); ?>

  <?php if (!empty($data['tags'])) { ?>
    <div class="mb15">
      <?php foreach ($data['tags'] as $tag) { ?>
        <a class="tags-xs" href="<?= getUrlByName('favorites.folder.id', ['id' => $tag['id']]); ?>"><?= $tag['value']; ?></a>
      <?php } ?>
    </div>
  <?php } ?>

  <?php if (!empty($data['favorites'])) { ?>
    <?php foreach ($data['favorites'] as $fav) { ?>
      <div class="box-white relative">
        <div class="left gray-600 mr5"> <?= Translate::get($fav['action_type']); ?>:</div>

        <?php if ($fav['action_type'] == 'post') { ?>
          <a class="font-normal" href="<?= getUrlByName('post', ['id' => $fav['post_id'], 'slug' => $fav['post_slug']]); ?>">
            <?= $fav['post_title']; ?>
          </a>
        <?php } elseif ($fav['action_type'] == 'website') { ?>
          <a class="block" href="<?= getUrlByName('web.website', ['slug' => $fav['item_url_domain']]); ?>">
            <?= $fav['item_title_url']; ?>
          </a>
          <span class="green-600 text-sm">
            <?= website_img($fav['item_url_domain'], 'favicon', $fav['item_url_domain'], 'favicons'); ?>
            <?= $fav['item_url_domain']; ?>
            <a target="_blank" href="<?= $fav['item_url']; ?>" class="item_cleek" data-id="<?= $fav['item_id']; ?>" rel="nofollow noreferrer ugc">
              <i class="bi bi-folder-symlink middle ml15 mr5"></i>
              <?= $fav['item_url']; ?>
            </a>
          </span>
        <?php } else { ?>
          <a href="<?= getUrlByName('post', ['id' => $fav['post']['post_id'], 'slug' => $fav['post']['post_slug']]); ?>#answer_<?= $fav['answer_id']; ?>">
            <?= $fav['post']['post_title']; ?>
          </a>
        <?php } ?>

        <?php if (!empty($fav['action_type']) == 'answer') {
          echo $fav['answer_content'];
        } ?>

        <span id="fav-comm" class="add-favorite right ml15 text-sm" data-front="personal" data-id="<?= $fav['tid']; ?>" data-type="<?= $fav['action_type']; ?>">
          <i class="bi bi-trash red-500"></i>
        </span>
        <?php if ($fav['tag_id']) { ?>
          <a class="tags-xs ml15" href="<?= getUrlByName('favorites.folder.id', ['id' => $fav['tag_id']]); ?>">
            <?= $fav['tag_title']; ?>
          </a>
          <sup class="del-folder-content gray-600" data-tid="<?= $fav['tid']; ?>" data-type="favorite">x</sup>
        <?php } else { ?>
          <span class="trigger right lowercase gray-600 text-sm"> <i class="bi-plus-lg gray-400 mr5"></i></span>
          <span class="dropdown right">
            <?php if ($data['tags']) { ?>
              <?php foreach ($data['tags'] as $tag) { ?>
                <div class="save-folder gray-600 text-sm p5" data-id="<?= $tag['id']; ?>" data-tid="<?= $fav['tid']; ?>" data-type="favorite"><?= $tag['value']; ?></div>
              <?php } ?>
            <?php } else { ?>
              <?= Translate::get('no'); ?>...
            <?php }  ?>
          </span>
        <?php } ?>
      </div>
    <?php } ?>
  <?php } else { ?>
    <div class="p20 center gray-400">
      <i class="bi bi-bookmark block text-8xl"></i>
      <?= Translate::get('no.favorites'); ?>
    </div>
  <?php } ?>
</main>
<aside class="col-span-3 mb-none">
  <div class="box-white text-sm sticky top-sm">
    <?= Translate::get('info-favorite'); ?>
  </div>
</aside>