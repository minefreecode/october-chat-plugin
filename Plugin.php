<?php namespace AlekseyPavlov\Chat;

use Backend;
use System\Classes\PluginBase;

/**
 * chat Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Чат',
            'description' => 'Описание плагина',
            'author'      => 'Aleksey Pavlov',
            'icon'        => 'icon-user'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'AlekseyPavlov\Chat\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'aleksey_pavlov.chat.some_permission' => [
                'tab' => 'chat',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'chat' => [
                'label'       => 'chat',
                'url'         => Backend::url('aleksey_pavlov/chat/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['aleksey_pavlov.chat.*'],
                'order'       => 500,
            ],
        ];
    }
}
