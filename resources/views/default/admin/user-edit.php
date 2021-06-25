<?php include TEMPLATE_DIR . '/header.php'; ?>
<div class="wrap">
    <main class="admin">
        <div class="white-box">
            <div class="inner-padding">
                <h1>
                    <a href="/admin"><?= lang('Admin'); ?></a> / <span class="red"><?= $data['meta_title']; ?></span>
                </h1>

                <div class="box badges">
                    <form action="/admin/user/edit/<?= $user['id']; ?>" method="post">
                        <?= csrf_field() ?>
             
                        <a class="right" href="/u/<?= $user['login']; ?>/delete/cover">
                            <?= lang('Remove'); ?>
                        </a>
                        <br>
                        <img width="325" class="right" src="<?= user_cover_url($user['cover_art']); ?>">
                        <img width="65" src="<?= user_avatar_url($user['avatar'], 'max'); ?>"> 

                        <div class="boxline">
                            <label class="form-label" for="post_title">
                                Id<?= $user['id']; ?> | 
                                <a target="_blank" rel="noopener noreferrer" href="/u/<?= $user['login']; ?>">
                                    <?= $user['login']; ?>
                                </a>
                            </label>
                            <?php if($user['trust_level'] != 5) { ?>                 
                                <?php if($user['isBan']) { ?>
                                    <span class="user-ban" data-id="<?= $user['id']; ?>">
                                        <span class="red"><?= lang('unban'); ?></span>
                                    </span>
                                <?php } else { ?>
                                    <span class="user-ban" data-id="<?= $user['id']; ?>">
                                        <span class="green">+ <?= lang('ban it'); ?></span>
                                    </span>
                                <?php } ?>
                            <?php } else { ?> 
                                ---
                            <?php } ?>   
                        </div>
                        
                       <div class="boxline"> 
                           <?php if($data['post_num_user'] != 0) { ?>
                                <label class="required"><?= lang('Posts-m'); ?>:</label>
                                <a target="_blank" rel="noopener noreferrer" title="<?= lang('Posts-m'); ?> <?= $user['login']; ?>" href="/u/<?= $user['login']; ?>/posts">
                                    <?= $data['post_num_user']; ?>
                                </a>
                                <br>
                            <?php } ?>
                            <?php if($data['answ_num_user'] != 0) { ?>
                                <label class="required"><?= lang('Answers'); ?>:</label>
                                <a target="_blank" rel="noopener noreferrer" title="<?= lang('Answers'); ?> <?= $user['login']; ?>" href="/u/<?= $user['login']; ?>/answers">
                                    <?= $data['answ_num_user']; ?>
                                </a>
                                <br>
                            <?php } ?>
                            <?php if($data['comm_num_user'] != 0) { ?>
                                <label class="required"><?= lang('Comments'); ?>:</label>
                                    <a target="_blank" rel="noopener noreferrer" title="<?= lang('Comments'); ?> <?= $user['login']; ?>" href="/u/<?= $user['login']; ?>/comments">
                                        <?= $data['comm_num_user']; ?>
                                    </a>
                                <br>
                            <?php } ?>
                            <?php if($data['space_user']) { ?>
                                <br>
                                <label class="required"><?= lang('Created by'); ?>:</label>
                                <br>
                                <span class="d">
                                    <?php foreach ($data['space_user'] as  $space) { ?>
                                        <div class="profile-space">
                                            <img src="<?= spase_logo_url($space['space_img'], 'small'); ?>" alt="<?= $space['space_name']; ?>">
                                            <a href="/s/<?= $space['space_slug'];?>"><?= $space['space_name'];?></a> 
                                        </div>
                                    <?php } ?>
                                </span>     
                            <?php } ?>
                        </div>
                        
                        <div class="boxline">
                            <label class="form-label" for="post_title"><?= lang('Badge'); ?></label>
                            <a class="lowercase" href="/admin/badge/user/add/<?= $user['id']; ?>">
                                <?= lang('Reward the user'); ?>
                            </a>
                        </div>
                        <div class="boxline">
                            <label class="form-label" for="post_title"><?= lang('Badges'); ?></label>
                            <?php if ($user['badges']) { ?>
                                <?php foreach ($user['badges'] as $badge) { ?>
                                    <?= $badge['badge_icon']; ?>
                                <?php } ?>
                            <?php } else { ?>    
                                ---
                            <?php } ?>
                        </div>
                        <div class="boxline">
                            <label for="post_title"><?= lang('Views'); ?></label>
                            <?= $user['hits_count']; ?>
                        </div>
                        <div class="boxline">
                            <label class="form-label" for="post_title"><?= lang('Sign up'); ?></label>
                            <?= $user['created_at']; ?> | 
                            <?= $user['reg_ip']; ?>  
                            <?php if($user['replayIp'] > 1) { ?>
                            <sup class="red">(<?= $user['replayIp']; ?>)</sup>
                            <?php } ?> <br>
                        </div>
                        <div class="boxline">
                            <label class="form-label" for="post_title">E-mail</label>
                            <input class="form-input" type="text" name="email" value="<?= $user['email']; ?>" required>
                        </div>
                        <div class="boxline">
                            <label class="form-label" for="post_title">TL</label>
                            <select name="trust_level">
                                <?php for($i=0; $i<=5; $i++) {  ?>
                                    <option <?php if($user['trust_level'] == $i) { ?>selected<?php } ?> value="<?= $i; ?>">
                                        <?= $i; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="boxline">
                            <label for="post_title"><?= lang('Nickname'); ?>:</label>
                            /u/***
                            <input class="form-input" type="text" name="login" value="<?= $user['login']; ?>" required>
                        </div>
                        <div class="boxline">
                            <label class="form-label" for="post_title"><?= lang('Name'); ?></label>            
                            <input class="form-input" type="text" name="name" value="<?= $user['name']; ?>">
                        </div>
                        <div class="boxline">
                            <label class="form-label" for="post_title"><?= lang('About me'); ?></label>
                            <textarea class="add" name="about"><?= $user['about']; ?></textarea>
                        </div>

                        <h3><?= lang('Contacts'); ?></h3>
                       
                        <div class="boxline">
                            <label class="form-label" for="name"><?= lang('URL'); ?></label>
                            <input type="text" class="form-input" name="website" id="name" value="<?= $user['website']; ?>">
                            <div class="box_h">https://site.ru</div>
                        </div>
                              
                        <div class="boxline">
                            <label class="form-label" for="name"><?= lang('City'); ?></label>
                            <input type="text" class="form-input" name="location" id="name" value="<?= $user['location']; ?>">
                            <div class="box_h">Москва</div>
                        </div>

                        <div class="boxline">
                            <label class="form-label" for="name"><?= lang('E-mail'); ?></label>
                            <input type="text" class="form-input" name="public_email" id="name" value="<?= $user['public_email']; ?>">
                            <div class="box_h">**@**.ru</div>
                        </div>

                        <div class="boxline">
                            <label class="form-label" for="name"><?= lang('Skype'); ?></label>
                            <input type="text" class="form-input" name="skype" id="name" value="<?= $user['skype']; ?>">
                            <div class="box_h">skype:<b>NICK</b></div>
                        </div>

                        <div class="boxline">
                            <label class="form-label" for="name"><?= lang('Twitter'); ?></label>
                            <input type="text" class="form-input" name="twitter" id="name" value="<?= $user['twitter']; ?>">
                            <div class="box_h">https://twitter.com/<b>NICK</b></div>
                        </div>

                        <div class="boxline">
                            <label class="form-label" for="name"><?= lang('Telegram'); ?></label>
                            <input type="text" class="form-input" name="telegram" id="name" value="<?= $user['telegram']; ?>">
                            <div class="box_h">tg://resolve?domain=<b>NICK</b></div>
                        </div>

                        <div class="boxline">
                            <label class="form-label" for="name"><?= lang('VK'); ?></label>
                            <input type="text" class="form-input" name="vk" id="name" value="<?= $user['vk']; ?>">
                            <div class="box_h">https://vk.com/<b>NICK / id</b></div>
                        </div>  
                        
                        
                        <input type="submit" class="button" name="submit" value="<?= lang('Edit'); ?>" />
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php include TEMPLATE_DIR . '/_block/admin-menu.php'; ?>
</div>
<?php include TEMPLATE_DIR . '/footer.php'; ?>