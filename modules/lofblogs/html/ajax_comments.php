<?php if (isset($comment_note) && $comment_note) : ?>
    <div id="lofcomment_error" class="display_warning"><?php echo $comment_note; ?></div>
    <script type="text/javascript">$('.display_warning').delay(3000).fadeOut(1000);</script>
<?php endif; ?>
<?php if (count($comments)) : ?>
    <ul id="lofcontent_comments_list">
        <?php foreach ($comments as $comment) : ?>
            <li>
                <div class="comment-avatar">
                    <img src="<?php echo $this->theme_images . 'default_avatar.jpg'; ?>" alt="Avatar" />
                </div>
                <div class="comment-main">
                    <p class="lofcomment_header">
                    <p class="comment-name">
                        <span class="author-name"><?php echo $comment['name'] ?></span>
                        <span class="say-text"><?php echo $this->module->l(' says :'); ?></span>
                    </p>
                    <span class="comment-date"><?php echo $comment['date_add'] ?></span>
                    <p class="comment-content"><?php echo lofContentHelper::buildEmoticons($comment['content']); ?></p>               
                    <div id="vote_buttons<?php echo $comment['id']; ?>" class="comment-panel">
                        <?php echo $comment['vote_buttons']; ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if ($this->params->get('showPagi', 1)): ?>
        <div id="lofcontent_comments_paginator"></div>    
        <script type="text/javascript">
            $(document).ready(function() {
                $('#lofcontent_comments_paginator').smartpaginator({ 
                    totalrecords: <?php echo count($comments); ?>,
                    recordsperpage: <?php echo $this->params->get('cmEachPage', 5); ?>,
                    datacontainer: 'lofcontent_comments_list', 
                    dataelement: 'li',
                    theme: '<?php echo $this->params->get('cmPagiTheme', 'black'); ?>',
                    onchange: function(){
                        $('html, body').animate({
                            scrollTop: $("#lofcontent_comments_list").offset().top
                        }, 1000);
                    }
                });
            });
        </script>        
    <?php endif; ?>
<?php else: ?>
    <div class="frontend-note">
        <?php echo $this->module->l('There is no comment'); ?>
    </div>
<?php endif; ?>
