<?php namespace Anch0rman\FantasyNormalizer;

use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'FantasyNormalizer',
            'description' => 'Normalize NFL player points based on unique league settings',
            'author' => 'Anch0rman',
            'icon' => 'icon-sort-amount-desc'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            'Anch0rman\FantasyNormalizer\Components\LeagueData' => 'leagueData',
            'Anch0rman\FantasyNormalizer\Components\PlayerData' => 'playerData',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'anch0rman.fantasynormalizer.some_permission' => [
                'tab' => 'FantasyNormalizer',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'fantasynormalizer' => [
                'label' => 'FantasyNormalizer',
                'url' => Backend::url('anch0rman/fantasynormalizer/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['anch0rman.fantasynormalizer.*'],
                'order' => 500,
            ],
        ];
    }
}
