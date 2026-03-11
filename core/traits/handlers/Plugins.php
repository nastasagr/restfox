<?php

trait PluginsHandler
{
    /**
     * Handler for /restfox/v1/plugins.
     *
     * @method GET
     */
    public function get_plugins()
    {
        $show_plugins = (int) get_option('restfox_show_plugins', 0);

        if (!$show_plugins) {
            return new WP_Error(
                'rest_forbidden',
                'This feature is disabled by RestFox API settings',
                ['status' => 403]
            );
        }

        $plugins = get_plugins();
        $data = [];

        foreach ($plugins as $plugin_path => $plugin) {
            $data[] = [
                'name' => $plugin['Name'],
                'plugin_url' => $plugin_path,
                'version' => $plugin['Version'],
                'author' => $plugin['Author'],
            ];
        }

        return [
            'plugins' => $data,
        ];
    }

    /**
     * Handler for /restfox/v1/plugins/disable.
     *
     * @method POST
     */
    public function disable_plugin($request)
    {
        $plugin = sanitize_text_field($request['plugin']);

        if ($plugin === RESTFOX_BASENAME) {
            return new WP_Error('rest_forbidden', 'Cannot deactivate RestFox plugin', ['status' => 403]);
        }

        if (!$plugin) {
            return new WP_Error(
                'missing_plugin',
                'Plugin parameter is required',
                ['status' => 400]
            );
        }

        if (!is_plugin_active($plugin)) {
            return new WP_Error(
                'plugin_not_active',
                'Plugin is not active',
                ['status' => 400]
            );
        }

        deactivate_plugins($plugin);

        return [
            'success' => true,
            'message' => 'Plugin disabled successfully',
            'plugin' => $plugin,
        ];
    }

    /**
     * Handler for /restfox/v1/plugins/uninstal.
     *
     * @method DELETE
     */
    public function uninstall_plugin($request)
    {
        require_once ABSPATH.'wp-admin/includes/plugin.php';
        require_once ABSPATH.'wp-admin/includes/file.php';

        $plugin = sanitize_text_field($request['plugin']);

        if ($plugin === RESTFOX_BASENAME) {
            return new WP_Error('rest_forbidden', 'Cannot uninstall RestFox plugin', ['status' => 403]);
        }

        if (!$plugin) {
            return new WP_Error(
                'missing_plugin',
                'Plugin parameter is required',
                ['status' => 400]
            );
        }

        if (!file_exists(WP_PLUGIN_DIR.'/'.$plugin)) {
            return new WP_Error(
                'plugin_not_found',
                'Plugin not found',
                ['status' => 404]
            );
        }

        // deactivate first if active
        if (is_plugin_active($plugin)) {
            deactivate_plugins($plugin);
        }

        $result = delete_plugins([$plugin]);

        if (is_wp_error($result)) {
            return $result;
        }

        return [
            'success' => true,
            'message' => 'Plugin uninstalled successfully',
            'plugin' => $plugin,
        ];
    }
}
