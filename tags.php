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

  public function content ($params, Smarty_Internal_Template $smarty)
  {
    $view = geoView::getInstance();

    $page_id = $view->getPage()->page_id;
    $category_id = $view->getCategory();
    $region_id = $view->geographic_navigation_region;

    $content = geoAddon::getUtil($this->name)->getContent($page_id, $category_id, $region_id);

    $smarty->tpl_vars['dry_templating_content'] = $content;
    $smarty->assign($smarty->tpl_vars);
  }
}
