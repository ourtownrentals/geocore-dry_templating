<?php
/**
 * @package DRYTemplatingAddon
 */

require_once ADDON_DIR . 'dry_templating/info.php';

class addon_dry_templating_setup extends addon_dry_templating_info
{
  public function install ()
  {
    $db = $admin = true;
    include(GEO_BASE_DIR . 'get_common_vars.php');

    $sql[] = "CREATE TABLE IF NOT EXISTS " . self::CONTENT_TABLE . " (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `category` smallint(4) unsigned NOT NULL,
      `region` smallint(4) unsigned NOT NULL,
      `page` varchar(150) DEFAULT NULL,
      `name` varchar(20) NOT NULL,
      `order` decimal(6,2) NOT NULL DEFAULT '1',
      `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
      `persist` tinyint(1) unsigned NOT NULL DEFAULT '0',
      `content` text NOT NULL,
      PRIMARY KEY (`id`),
      KEY `category` (`category`),
      KEY `region` (`region`),
      KEY `page` (`page`),
      KEY `name` (`name`),
      KEY `active` (`active`)
      ) DEFAULT CHARSET=utf8;";

    $errors = $this->executeSQL($sql, $db);

    if (!empty($errors)) {
      foreach ($errors as $error) {
        $admin->userError('Database execution error, install failed: ' . $error);
      }
      return false;
    }

    return true;
  }

  public function uninstall ()
  {
    $db = $admin = true;
    include(GEO_BASE_DIR . 'get_common_vars.php');

    $sql[] = "DROP TABLE IF EXISTS " . self::CONTENT_TABLE;

    $errors = $this->executeSQL($sql, $db);

    if (!empty($errors)) {
      foreach ($errors as $error) {
        $admin->userError('Database execution error, un-install failed: ' . $error);
      }
      return false;
    }

    return true;
  }

  private function executeSQL ($sql, $db)
  {
    foreach($sql as $query) {
      $result = $db->Execute($query);
      if (!$result) {
        $errors[] = $db->ErrorMsg();
      }
    }

    return $errors;
  }
}
