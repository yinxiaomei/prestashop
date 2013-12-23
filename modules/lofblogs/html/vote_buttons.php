<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php if ($isVoted <= 0) : ?>
    <div class="vote_btn_container">
        <a href="javascript:void(0)" onClick="commentVote('<?php echo $comment['id']; ?>', 'down');" title="vote down">
            <img src="<?php echo $img_down; ?>" />
            <span id="comment_vote_down<?php echo $comment['id']; ?>"><?php echo $comment['vote_down']; ?></span>
        </a>
    </div>                         
    <div class="vote_btn_container">
        <a href="javascript:void(0)" onClick="commentVote('<?php echo $comment['id']; ?>', 'up');" title="vote up">
            <img src="<?php echo $img_up; ?>" />
            <span id="comment_vote_up<?php echo $comment['id']; ?>"><?php echo $comment['vote_up']; ?></span>
        </a>                        
    </div>
<?php else : ?>
    <div class="vote_btn_container">
        <img src="<?php echo $img_down; ?>" />
        <span id="comment_vote_down<?php echo $comment['id']; ?>"><?php echo $comment['vote_down']; ?></span>
    </div>                         
    <div class="vote_btn_container">
        <img src="<?php echo $img_up; ?>" />
        <span id="comment_vote_up<?php echo $comment['id']; ?>"><?php echo $comment['vote_up']; ?></span>
    </div>
<?php endif; ?>

