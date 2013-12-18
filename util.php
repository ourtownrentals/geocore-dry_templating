<?php
/**
 * @package DRYTemplatingAddon
 */
class addon_dry_templating_util extends addon_dry_templating_info
{
  /**
  * @param Integer $page_id
  *
  * @return Array page group names which are assigned to the page id
  */
  public function getPageGroups ($page_id)
  {
    $page_groups = geoAddon::getRegistry($this->name)->page_groups;

    $matches = array();
    foreach ($page_groups as $page_group) {
      if (array_search($page_id, $page_group['page_ids'])) {
        array_push($matches, $page_group['name']);
      }
    }

    return array_values($matches);
  }
}
