{$admin_messages}
<form action="" method="post">
  <fieldset>
    <legend>Page Groups</legend>
    <div>
      <p class="page_note">Each line associates a set of page ids with a page group name. Group names must contain letters and underscores only.</p>
      <table>
        <thead>
          <tr class="col_hdr_top">
            <th style="color:red;">X</th>
            <th>Name</th>
            <th>Page IDs (comma separated list)</th>
          </tr>
        </thead>
        <tbody>
        {foreach $page_groups as $page_group}
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
        <input type="submit" name="auto_save" class="mini_button" value="Save Page Groups" />
      </div>
    </div>
  </fieldset>
</form>

<form action="" method="post">
  <fieldset>
    <legend>Content Groups</legend>
    <div>
      <p class="page_note"></p>
      <table>
        <thead>
          <tr class="col_hdr_top">
            <th style="color:red;">X</th>
            <th>Name</th>
            <th>Cascade</th>
          </tr>
        </thead>
        <tbody>
        {foreach $content_groups as $content_group}
          <tr class="{cycle values='row_color1,row_color2'}">
            <td class="{$row_color}"><input type="checkbox" name="content_groups[{$content_group.id}][remove]" value="1" /></td>
            <td class="{$row_color}"><input type="text" size="25" name="content_groups[{$content_group.id}][name]" value="{$content_group.name}" /></td>
            <td class="{$row_color}"><input type="checkbox" name="content_groups[{$content_group.id}][cascade]"{if $content_group.cascade eq 1} checked="checked"{/if} /></td>
          </tr>
        {/foreach}
          <tr class="{cycle values='row_color1,row_color2'}">
            <th class="{$row_color}">New</th>
            <td class="{$row_color}"><input type="text" size="25" name="content_groups[new][name]" /></td>
            <td class="{$row_color}"><input type="checkbox" name="content_groups[new][cascade]" /></td>
          </tr>
        </tbody>
      </table>
      <div class="center">
        <input type="submit" name="auto_save" class="mini_button" value="Save Content Groups" />
      </div>
    </div>
  </fieldset>
</form>
