<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php if (count($files)) : ?>
    <form action="<?php echo $formAction; ?>" method="post" enctype="multipart/form-data">  

        <div class="emoticon_upload">
            <h3><?php echo $this->l('Upload Emoticon'); ?></h3>
            <div class="emoticon_upload_wrapper">
                <input type="file" name="file" value="" />
                <input type="submit" name="add_new_emoticon" value="Add" />
            </div>
        </div>
        <div id="emoticons_container">
            <?php
            foreach ($files as $k => $image) :
                $name = str_replace('.', '__', $image);
                if (isset($datas[$name])) {
                    $value = $datas[$name];
                } else {
                    $value = '';
                };
                ?>
                <div class="editable_emotions">
                    <div class="img_preview"><img src="<?php echo $emoticons_uri . $image; ?>" /></div>
                    <input type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
                    <div id="<?php echo $k; ?>" class="check_remove">Delete</div>
                    <input id="checkbox<?php echo $k; ?>" type="checkbox" name="removing_emoticons[]" value="<?php echo $image; ?>" />
                </div>
            <?php endforeach; ?>
        </div>
        <div id="panel_bar">
            <input type="submit" name="emoticons_update" value="update" class="lofcontent_button" />
        </div>        
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.check_remove').click(function(){             
                var checkbox = $('#checkbox'+$(this).attr('id'));              
                checkbox.trigger('click');
                $(this).toggleClass('image_for_remove');
            });
        });
    </script>
<?php endif; ?>
