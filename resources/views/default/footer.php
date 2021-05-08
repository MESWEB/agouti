</div>
<footer>
    <div class="wrap">
        <div class="right">
            <a title="<?= lang('Users'); ?>" href="/users"><?= lang('Users'); ?></a>
            <a title="<?= lang('Search'); ?>" href="/search"><?= lang('Search'); ?></a> 
            <a title="<?= lang('Help'); ?>" href="/info"><?= lang('Help'); ?></a>
        </div>
    </div>
</footer>
<script async src="/assets/js/common.js"></script>  
<?php if($uid['id']) { ?>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/app.js"></script>
<?php } ?>
<?php print getRequestResources()->getBottomStyles(); ?>
<?php print getRequestResources()->getBottomScripts(); ?> 
</html> 