<?php
/**
 * Update
 *
 * PHP version 5
 *
 * @category    Board
 * @package     Xpressengine\Plugins\Board
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace Xpressengine\Plugins\Board\Plugin;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use XeToggleMenu;
use XeConfig;
use XeDB;
use XePlugin;
use Xpressengine\Plugins\Board\Components\ToggleMenus\Shares\CopyItem;
use Xpressengine\Plugins\Board\Components\ToggleMenus\Shares\FacebookItem;
use Xpressengine\Plugins\Board\Components\ToggleMenus\Shares\LineItem;
use Xpressengine\Plugins\Board\Components\ToggleMenus\Shares\TwitterItem;
use Xpressengine\Plugins\Board\Components\UIObjects\Share\ShareUIObject;
use Xpressengine\Plugins\Board\ConfigHandler;

/**
 * Update
 *
 * Plugin update 에 필요한 코드.
 * 버전 업데이트할 때 필요한 코드 계속 추가.
 *
 * @category    Board
 * @package     Xpressengine\Plugins\Board
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Update
{
    /**
     * check update
     *
     * @param null $installedVersion installed version
     * @return bool
     */
    public static function check($installedVersion = null)
    {
        // ver 0.9.1
        if (XeConfig::get(XeToggleMenu::getConfigKey(ConfigHandler::CONFIG_NAME, null)) == null) {
            return false;
        }

        $installedVersion = XePlugin::getPlugin('board')->getInstalledVersion();

        // ver 0.9.2
        if ($installedVersion !== null && static::hasSlugTableSlugUnique($installedVersion) === false) {
            return false;
        }

        // ver 0.9.5
        if (static::hasConfigCaptchaTag() === false) {
            return false;
        }

        // ver 0.9.14
        if (static::hasConfigUrlType() === false) {
            return false;
        }

        // ver 0.9.14
        if (static::hasConfigDeleteToTrash() === false) {
            return false;
        }

        // ver 0.9.16
        if (static::hasConfigNewCommentNotice() === false) {
            return false;
        }

        // ver 0.9.22
        if ($installedVersion !== null && static::hasCommonSkinConfig($installedVersion) === false) {
            return false;
        }

        // ver 0.9.22
        if (static::hasShareToggleMenuConfig() === false) {
            return false;
        }

        return true;
    }

    /**
     * update process execute
     *
     * @param null $installedVersion install version
     * @return void
     */
    public static function proc($installedVersion = null)
    {
        Resources::putLang();

        // ver 0.9.1
        if (XeConfig::get(XeToggleMenu::getConfigKey(ConfigHandler::CONFIG_NAME, null)) == null) {
            XeToggleMenu::setActivates(ConfigHandler::CONFIG_NAME, null, [
                'module/board@board/toggleMenu/xpressengine@trashItem',
            ]);
        }

        $installedVersion = XePlugin::getPlugin('board')->getInstalledVersion();

        // ver 0.9.2
        if ($installedVersion !== null && static::hasSlugTableSlugUnique($installedVersion) === false) {
            $schema = Schema::setConnection(XeDB::connection('document')->master());
            $schema->table('board_slug', function (Blueprint $table) {
                $table->dropIndex(array('slug'));
                $table->unique(array('slug'));
            });
        }

        // ver 0.9.5
        if (static::hasConfigCaptchaTag() === false) {
            $config = XeConfig::get(ConfigHandler::CONFIG_NAME);
            if ($config->get('useCaptcha') === null) {
                $config->set('useCaptcha', false);
            }

            if ($config->get('useTag') === null) {
                $config->set('useTag', true);
            }

            XeConfig::modify($config);
        }

        // ver 0.9.14
        if (static::hasConfigUrlType() === false) {
            $config = XeConfig::get(ConfigHandler::CONFIG_NAME);
            if ($config->get('urlType') === null) {
                $config->set('urlType', 'slug');
            }

            XeConfig::modify($config);
        }

        // ver 0.9.14
        if (static::hasConfigDeleteToTrash() === false) {
            $config = XeConfig::get(ConfigHandler::CONFIG_NAME);
            if ($config->get('deleteToTrash') === null) {
                $config->set('deleteToTrash', false);
            }

            XeConfig::modify($config);
        }

        // ver 0.9.16
        if (static::hasConfigNewCommentNotice() === false) {
            $config = XeConfig::get(ConfigHandler::CONFIG_NAME);
            if ($config->get('newCommentNotice') === null) {
                $config->set('newCommentNotice', true);
            }

            XeConfig::modify($config);
        }

        // ver 0.9.22
        if ($installedVersion !== null && static::hasCommonSkinConfig($installedVersion) === false) {
            $menuItems = \XpressEngine\Menu\Models\MenuItem::where('type', 'board@board')->get();

            foreach ($menuItems as $menuItem) {
                $config = XeConfig::get('skins.configs.module/board@board:' . $menuItem->id);
                if ($config != null) {
                    $config->set('module/board@board/skin/board@default', []);
                    XeConfig::modify($config);
                }
            }
        }

        // ver 0.9.22
        if (static::hasShareToggleMenuConfig() === false) {
            XeToggleMenu::setActivates(ShareUIObject::CONFIG_NAME, null, [
                CopyItem::getId(),
                FacebookItem::getId(),
                LineItem::getId(),
                TwitterItem::getId(),
            ]);
        }
    }

    /**
     * has config for version 0.9.5
     *
     * @return bool
     */
    protected static function hasConfigCaptchaTag()
    {
        $config = XeConfig::get(ConfigHandler::CONFIG_NAME);
        if ($config->get('useCaptcha') === null || $config->get('useTag') === null) {
            return false;
        }
        return true;
    }

    /**
     * 0.9.1 이하 버전은 slug를 unique 하게 해야함
     *
     * @param string $installedVersion installed version
     * @return bool
     */
    protected static function hasSlugTableSlugUnique($installedVersion)
    {
        if (version_compare($installedVersion, '0.9.1', '<=')) {
            return false;
        }

        return true;
    }

    /**
     * check configuration for urlType
     *
     * @return bool
     */
    protected static function hasConfigUrlType()
    {
        $config = XeConfig::get(ConfigHandler::CONFIG_NAME);
        if ($config->get('urlType') === null) {
            return false;
        }
        return true;
    }

    /**
     * check configuration for deleteToTrash
     *
     * @return bool
     */
    protected static function hasConfigDeleteToTrash()
    {
        $config = XeConfig::get(ConfigHandler::CONFIG_NAME);
        if ($config->get('deleteToTrash') === null) {
            return false;
        }
        return true;
    }

    /**
     * check configuration for newCommentNotice
     *
     * @return bool
     */
    protected static function hasConfigNewCommentNotice()
    {
        $config = XeConfig::get(ConfigHandler::CONFIG_NAME);
        if ($config->get('newCommentNotice') === null) {
            return false;
        }
        return true;
    }

    /**
     * 0.9.21 이하 버전은 기본 스킨 설정 변경
     *
     * @param string $installedVersion installed version
     * @return bool
     */
    protected static function hasCommonSkinConfig($installedVersion)
    {
        if (version_compare($installedVersion, '0.9.21', '<=')) {
            return false;
        }

        return true;
    }

    /**
     * check configuration for share toggle menu
     *
     * @return bool
     */
    protected static function hasShareToggleMenuConfig()
    {
        $config = XeConfig::get(XeToggleMenu::getConfigKey(ShareUIObject::CONFIG_NAME, null));
        if ($config=== null) {
            return false;
        }
        return true;
    }
}
