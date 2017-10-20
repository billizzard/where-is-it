<?php
/**
 * Created by PhpStorm.
 * User: v
 * Date: 20.10.17
 * Time: 12.09
 */
?>

<div class="iu">
    <div class="iu_gallery">
    </div>
    <input type="file" name="<?=$inputFileName?>" data-uploadUrl="<?=$uploadUrl?>"
           data-maxFiles="<?=$maxFiles?>"
           data-errorCallback="<?=$errorCallback?>"
           data-deleteUrl="<?=$deleteUrl?>"
    <?= $maxFiles > 1 ? 'multiple' : ''?>>

    <input type="hidden" class="js-image-url" value="" name="<?=$inputUrlName?>">
    <button class="add js-add">Добавить фото</button>
</div>
