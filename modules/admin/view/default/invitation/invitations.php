<?= includeTemplate(
  '/view/default/menu',
  [
    'data'  => $data,
    'meta'  => $meta,
    'menus' => []
  ]
); ?>

<div class="box-white">
  <?php if (!empty($data['invitations'])) { ?>
    <?php foreach ($data['invitations'] as $key => $inv) { ?>
      <div>
        <a href="<?= getUrlByName('profile', ['login' => $inv['uid']['login']]); ?>">
          <?= $inv['uid']['login']; ?>
        </a>
        <sup>id<?= $inv['uid']['id']; ?></sup>
        =>
        <?php if ($inv['login']) { ?>
          <a href="<?= getUrlByName('profile', ['login' => $inv['login']]); ?>">
            <?= $inv['login']; ?>
          </a>
          <span class="lowercase text-sm">
            <?= $inv['invitation_email']; ?>
          </span>
          <sup>id<?= $inv['active_uid']; ?></sup>
          <span class="text-sm"> - <?= lang_date($inv['active_time']); ?>
          <?php } else { ?>
            <span class="gray-400 lowercase text-sm">
              <?= $inv['invitation_email']; ?> &nbsp; <?= lang_date($inv['add_time']); ?>
            </span>
          <?php } ?>
          </span>
      </div>
    <?php } ?>
  <?php } else { ?>
    <?= no_content(Translate::get('no'), 'bi bi-info-lg'); ?>
  <?php } ?>
</div>
</main>
<?= includeTemplate('/view/default/footer'); ?>