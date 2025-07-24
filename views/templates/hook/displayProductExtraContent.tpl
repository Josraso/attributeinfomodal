{foreach from=$attribute_infos item=info}
    <div class="attribute-info-icon" data-attr="{$info.id_attribute}" data-text="{$info.info|escape:'html'}">
        <span class="attribute-icon">🛈</span>
    </div>
{/foreach}
<div id="attributeInfoModal" class="attribute-info-modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="attributeInfoText"></p>
    </div>
</div>