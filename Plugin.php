<?php

namespace Kanboard\Plugin\DemoData;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;

class Plugin extends Base {
  public function initialize() {
    $this->applicationAccessMap->add('DemoData', '*', Role::APP_ADMIN);

    $this->template->hook->attach('template:config:sidebar', 'demodata:config/sidebar');
  }

	public function getPluginName()
    {
        return 'Demo Data';
    }

    public function getPluginDescription()
    {
        return 'Generates/resets Sample Data';
    }

    public function getPluginAuthor()
    {
        return 'Bruno Deshayes';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/bdeshayes/html2pdf';
    }

  public function getCompatibleVersion() {
    return '>=1.0.48';
  }
}
