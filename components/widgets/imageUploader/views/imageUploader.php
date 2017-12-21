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
        <? if ($oldImages) {
            foreach ($oldImages as $image) {
                if (isset($image[0])) { ?>
                    <div class="iu_uploaded_img js-image">
                        <img src="/<?=$image[0]?>">
                        <? if ($deleteButton) { ?>
                        <span  class="iu-icon iu-icon-remove js-delete glyphicon glyphicon-remove" data-params='<?=isset($image[1]) ? json_encode($image[1]) : ""?>'></span>
                        <? } ?>
                        <? if ($downloadButton) {?>
                            <a target="_blank" href="/admin/default/download-image/<?= isset($image[1]['id']) ? '?id=' . $image[1]['id'] : ''?>" class="iu-icon iu-icon-download js-download glyphicon glyphicon-download" data-params='<?=isset($image[1]) ? json_encode($image[1]) : ""?>'></a>
                        <? } ?>
                    </div>
                <?}
            }
        }?>
    </div>
    <input type="file" name="<?=$inputFileName?>"
           data-uploadUrl="<?=$uploadUrl?>"
           data-maxFiles="<?=$maxFiles?>"
           data-errorCallback="<?=$errorCallback?>"
           data-deleteUrl="<?=$deleteUrl?>"
           data-deleteButton="<?=$deleteButton?>"
            <?= $maxFiles > 1 ? 'multiple' : ''?>
    >

    <input type="hidden" class="js-image-url" value="" name="<?=$inputUrlName?>">
    <input type="hidden" class="js-image-old-url" value="" name="old_<?=$inputUrlName?>">

    <? if ($uploadButton) { ?>
    <button class="add js-add">Добавить фото</button>
    <? } ?>
</div>
