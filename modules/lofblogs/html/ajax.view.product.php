<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$linkHelper = new Link();
?>
<?php if(is_array($products) && count($products)) : ?>
<?php foreach ($products as $product) : 
if(!isset($product['id_image']) || !$product['id_image']) {
    $product['id_image'] = $this->model->getImageId($product['id_product']);
}
$imageUrl = $linkHelper->getImageLink($product['link_rewrite'], $product['id_image'], 'medium_default');
$imageUrl = str_replace('localhost', '', $imageUrl);
?>
<li id="related_<?php echo $product['id_product']; ?>" class="product_item" onClick="addRelatedProduct(this);">
            <p ><?php echo $product['name']; ?></p>
            <img src="<?php echo $imageUrl; ?>"  
                 alt="<?php echo $product['name']; ?>" 
                 />
            <div class="deleted_img_label">Add to list</div>
        </li>
<?php endforeach; ?>
<?php else: ?>
        <p class="lofcontent_note">There is not any product in this category</p>
<?php endif; ?>
