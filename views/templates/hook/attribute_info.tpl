<script>var attributeInfoMap = {ldelim}{/ldelim};</script>
{foreach from=$attribute_infos key=group_id item=info}
    <script>
        attributeInfoMap[{$group_id}] = `{$info nofilter}`;
    </script>
{/foreach}