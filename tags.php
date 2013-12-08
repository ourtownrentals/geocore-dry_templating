<?php
/**
 * @package DRYTemplatingAddon
 */
class addon_dry_templating_tags extends addon_dry_templating_info
{
  public function template ($params, Smarty_Internal_Template $smarty)
  {
    $page_id = geoView::getInstance()->getPage()->page_id;
    $tpl_name = $params['name'] . '.tpl';

    $tpl_vars = array();
    $tpl_vars['groups'] = geoAddon::getUtil($this->name)->getPageGroups($page_id);

    return geoTemplate::loadInternalTemplate($params, $smarty, $tpl_name,
      geoTemplate::ADDON, $this->name, $tpl_vars);
  }
}
