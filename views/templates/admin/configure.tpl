<form method="post">
    <div class="form-group">
        <label for="id_attribute_group">Select Attribute Group:</label>
        <select name="id_attribute_group" class="form-control">
            {foreach from=$attributes item=attribute}
                <option value="{$attribute.id_attribute_group}" {if $selected_id == $attribute.id_attribute_group}selected{/if}>{$attribute.name}</option>
            {/foreach}
        </select>
    </div>
    <div class="form-group">
        <label for="info">Info Text (can use HTML):</label>
        <textarea name="info" class="form-control" rows="5">{$saved_info|escape:'htmlall':'UTF-8'}</textarea>
    </div>
    <button type="submit" name="submit_attribute_info" class="btn btn-primary">Save</button>
</form>