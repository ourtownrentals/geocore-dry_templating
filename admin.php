<?php
/**
 * @package DRYTemplatingAddon
 */
class addon_dry_templating_admin extends addon_dry_templating_info
{
  public function init_pages ($menuName)
  {
    menu_page::addonAddPage('addon_dry_templating_groups','','Page and Content Groups', $this->name);
  }

  public function display_addon_dry_templating_groups ()
  {
    $reg = geoAddon::getRegistry($this->name);

    // load existing page group data or submitted data on error
    if ($reg->page_groups_with_error) {
      $page_groups = $reg->page_groups_with_error;
    } elseif ($reg->page_groups) {
      $page_groups = $reg->page_groups;
    }

    // load existing content group data or submitted data on error
    if ($reg->content_groups_with_error) {
      $content_groups = $reg->content_groups_with_error;
    } elseif ($reg->content_groups) {
      $content_groups = $reg->content_groups;
    }

    // unset *_groups_with_error to avoid loop
    $reg->page_groups_with_error = null;
    $reg->content_groups_with_error = null;
    $reg->save();

    $tpl_vars = array();
    $tpl_vars['admin_messages'] = geoAdmin::m();

    if ($page_groups) {
      // convert the array of page ids to a comma separated list
      foreach ($page_groups as &$page_group) {
        $page_group['page_ids'] = implode(',', $page_group['page_ids']);
      }
      $tpl_vars['page_groups'] = $page_groups;
    }

    if ($content_groups) {
      $tpl_vars['content_groups'] = $content_groups;
    }

    geoView::getInstance()->setBodyTpl('admin/groups.tpl', $this->name)->setBodyVar($tpl_vars);
  }

  public function update_addon_dry_templating_groups ()
  {
    if (isset($_POST['page_groups'])) {
      $new_page_groups = $_POST['page_groups'];
    } elseif (isset($_POST['content_groups'])) {
      $new_content_groups = $_POST['content_groups'];
    } else {
      return false;
    }

    $admin = geoAdmin::getInstance();
    $reg = geoAddon::getRegistry($this->name);

    if ($new_page_groups) {
      $page_groups = array();

      // build the new list of page groups
      foreach ($new_page_groups as $key => $page_group) {
        // clean the input and check the input for errors
        $cleaned_result = $this->cleanPageGroupInput($key, $page_group);
        $page_group = $cleaned_result[0];
        $errors = $cleaned_result[1];

        // if there was an error add each error to the list of admin messages
        if ($errors) {
          $error = true;
          foreach ($errors as $error) {
            $admin->userError($error);
          }
        }

        if (!(is_null($page_group) || $page_group['remove'])) {
          array_push($page_groups, $page_group);
        }
      }

      array_multisort($page_groups);

      // give each group an id field
      foreach ($page_groups as $key => &$page_group) {
        $page_group['id'] = $key;
      }

      if ($error) {
        $admin->userError("Page groups not saved.");
        $reg->page_groups_with_error = $page_groups;
        $reg->save();
        return false;
      } else {
        $reg->page_groups = $page_groups;
        $reg->save();
        $admin->message("Page groups saved.");
        return true;
      }
    } elseif ($new_content_groups) {
      $content_groups = array();

      // build the new list of content groups
      foreach ($new_content_groups as $key => $content_group) {
        // clean the input and check the input for errors
        $cleaned_result = $this->cleanContentGroupInput($key, $content_group);
        $content_group = $cleaned_result[0];
        $errors = $cleaned_result[1];

        // if there was an error add each error to the list of admin messages
        if ($errors) {
          $error = true;
          foreach ($errors as $error) {
            $admin->userError($error);
          }
        }

        if (!(is_null($content_group) || $content_group['remove'])) {
          array_push($content_groups, $content_group);
        }
      }

      array_multisort($content_groups);

      // give each group an id field
      foreach ($content_groups as $key => &$content_group) {
        $content_group['id'] = $key;
      }

      if ($error) {
        $admin->userError("Content groups not saved.");
        $reg->content_groups_with_error = $content_groups;
        $reg->save();
        return false;
      } else {
        $reg->content_groups = $content_groups;
        $reg->save();
        $admin->message("Content groups saved.");
        return true;
      }
    }
  }

  private function cleanPageGroupInput ($id, $input)
  {
    $errors = array();

    // ignore a new group if field is empty
    if ($id == 'new' && (!$input['name'] && !$input['page_ids'])) {
      return array(null, $errors);
    }

    // fail if empty field
    if (!$input['name'] || !$input['page_ids']) {
      array_push($errors, 'Empty field.');
    }

    // strip all whitespace from page ids
    $input['page_ids'] = preg_replace('/\s+/', '', $input['page_ids']);

    // strip all whitespace from name
    $input['name'] = preg_replace('/\s+/', '', $input['name']);

    // only letters and underscores allowed in name
    if (preg_match('/[^A-Za-z_]/', $input['name'])) {
      array_push($errors, 'Invalid charater in group name: ' . $input['name']);
    }

    // only letters, numbers, underscores, and commas allowed in page id list
    if (preg_match('/[^A-Za-z0-9_,]/', $input['page_ids'])) {
      array_push($errors, 'Invalid charater in page id list: ' . $input['page_ids']);
    }

    // make name lowercase
    $input['name'] = strtolower($input['name']);

    // create array from list of page ids
    $input['page_ids'] = explode(',', $input['page_ids']);

    return array($input, $errors);
  }

  private function cleanContentGroupInput ($id, $input)
  {
    $errors = array();

    // ignore a new group if field is empty
    if ($id == 'new' && !$input['name']) {
      return array(null, $errors);
    }

    // fail if empty field
    if (!$input['name']) {
      array_push($errors, 'Empty field.');
    }

    // strip all whitespace from name
    $input['name'] = preg_replace('/\s+/', '', $input['name']);

    // only letters and underscores allowed in name
    if (preg_match('/[^A-Za-z_]/', $input['name'])) {
      array_push($errors, 'Invalid charater in group name: ' . $input['name']);
    }

    // make name lowercase
    $input['name'] = strtolower($input['name']);

    // force cascade to be boolean
    $input['cascade'] = ($input['cascade'] ? true : false);

    return array($input, $errors);
  }
}
