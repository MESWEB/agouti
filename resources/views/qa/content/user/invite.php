<main class="col-span-9 mb-col-12">
  <div class="box-white">
    <h1 class="mt0 mb10 text-2xl font-normal"><?= Translate::get('invite'); ?></h1>
    <form class="" action="/invite" method="post">
      <?php csrf_field(); ?>
      <fieldset>
        <label for="invite"><?= Translate::get('code'); ?></label>
        <input type="text" name="invite" id="invite">
      </fieldset>
      <fieldset>
        <?= sumbit(Translate::get('sign.in')); ?>
        <span class="ml15 text-sm"><a href="<?= getUrlByName('recover'); ?>">
            <?= Translate::get('forgot.password'); ?>?</a>
        </span>
      </fieldset>
    </form>
    <?php if (Config::get('general.invite') == true) { ?>
      <?= Translate::get('no-invate-txt'); ?>
    <?php } ?>
  </div>
</main>
<aside class="col-span-3 mb-none">
  <div class="box-white bg-violet-50 text-sm">
    <?= Translate::get('invited you'); ?>
  </div>
</aside>