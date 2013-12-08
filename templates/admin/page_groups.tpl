{$admin_messages}
<form action="" method="post">
  <fieldset>
    <legend>Page Groups</legend>
    <p>Each line associates a set of page ids with a page group name. Group names must contain letters and underscores only.</p>
    <div>
      <table>
        <thead>
          <tr class="col_hdr_top">
            <th style="color:red;">X</th>
            <th>Name</th>
            <th>Page IDs (comma separated list)</th>
          </tr>
        </thead>
        <tbody>
        {foreach from=$page_groups item="page_group"}
          <tr class="{cycle values='row_color1,row_color2'}">
            <td class="{$row_color}"><input type="checkbox" name="page_groups[{$page_group.id}][remove]" value="1" /></td>
            <td class="{$row_color}"><input type="text" size="25" name="page_groups[{$page_group.id}][name]" value="{$page_group.name}" /></td>
            <td class="{$row_color}"><input type="text" size="75" name="page_groups[{$page_group.id}][page_ids]" value="{$page_group.page_ids}" /></td>
          </tr>
        {/foreach}
          <tr class="{cycle values='row_color1,row_color2'}">
            <th class="{$row_color}">New</th>
            <td class="{$row_color}"><input type="text" size="25" name="page_groups[new][name]" /></td>
            <td class="{$row_color}"><input type="text" size="75" name="page_groups[new][page_ids]" /></td>
          </tr>
        </tbody>
      </table>
      <div class="center">
        <input type="submit" name="auto_save" class="mini_button" value="Save" />
      </div>
    </div>
  </fieldset>
</form>
