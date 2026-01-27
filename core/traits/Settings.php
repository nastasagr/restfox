<?php


trait Settings
{

    /**
     * Register options to WordPress.
     */
    public function register_restfox_settings()
    {
        register_setting(
            'restfox_settings_group',
            'restfox_show_themes',
            [
                'type'    => 'boolean',
                'default' => 0,
                'sanitize_callback' => fn($v) => (int) (bool) $v,
            ]
        );

        register_setting(
            'restfox_settings_group',
            'restfox_show_plugins',
            [
                'type'    => 'boolean',
                'default' => 0,
                'sanitize_callback' => fn($v) => (int) (bool) $v,
            ]
        );


        register_setting(
            'restfox_settings_group',
            'restfox_show_users',
            [
                'type'    => 'boolean',
                'default' => 0,
                'sanitize_callback' => fn($v) => (int) (bool) $v,
            ]
        );


        register_setting(
            'restfox_settings_group',
            'restfox_change_config',
            [
                'type'    => 'boolean',
                'default' => 0,
                'sanitize_callback' => fn($v) => (int) (bool) $v,
            ]
        );
    }

    /**
     * Admin menu page.
     */
    public function add_settings_page()
    {
        add_menu_page(
            'RestFox Settings',
            'RestFox',
            'manage_options',
            'restfox-settings',
            [$this, 'render_settings_page'],
            plugin_dir_url(__FILE__) . '../../assets/icons/icon.svg',
            30
        );
    }

    /**
     *  Fields of settings page
     */
    public function render_settings_page()
    {
        $show_themes   = get_option('restfox_show_themes', 0);
        $show_plugins  = get_option('restfox_show_plugins', 0);
        $show_users  = get_option('restfox_show_users', 0);
        $show_versions  = get_option('restfox_show_versions', 0);
        $change_config  = get_option('restfox_change_config', 0);
?>


<div class="restfox-wrap">

    <div class="logoarea">
        <div class="logo"></div>
    </div>


    <div class="restfox-card">

        <form method="post" action="options.php">
            <?php settings_fields('restfox_settings_group'); ?>

            <div class="restfox-options">

                <!-- installed themes option -->
                <div class="restfox-option">
                    <div class="option-details">
                        <div class="iconarea">
                            <div class="icon ic-themes"></div>
                        </div>

                        <div class="restfox-option-text">
                            <strong>Themes</strong><br>
                            <span>Manage installed themes</span>
                        </div>
                    </div>

                    <label class="toggle">
                        <input type="hidden" name="restfox_show_themes" value="0">
                        <input type="checkbox" name="restfox_show_themes" value="1" <?php checked(1, $show_themes); ?>>
                        <span class="toggle track"></span>
                    </label>
                </div>

                <!-- installed plugins option -->
                <div class="restfox-option">
                    <div class="option-details">
                        <div class="iconarea">
                            <div class="icon ic-plugins"></div>
                        </div>

                        <div class="restfox-option-text">
                            <strong>Plugins</strong><br>
                            <span>Manage installed plugins</span>
                        </div>
                    </div>

                    <label class="toggle">
                        <input type="hidden" name="restfox_show_plugins" value="0">
                        <input type="checkbox" name="restfox_show_plugins" value="1"
                            <?php checked(1, $show_plugins); ?>>
                        <span class="toggle track"></span>
                    </label>
                </div>

                <!-- view users option -->
                <div class="restfox-option">
                    <div class="option-details">
                        <div class="iconarea">
                            <div class="icon ic-users"></div>
                        </div>

                        <div class="restfox-option-text">
                            <strong>Users</strong><br>
                            <span>Manage registered users</span>
                        </div>
                    </div>

                    <label class="toggle">
                        <input type="hidden" name="restfox_show_users" value="0">
                        <input type="checkbox" name="restfox_show_users" value="1" <?php checked(1, $show_users); ?>>
                        <span class="toggle track"></span>
                    </label>
                </div>


                <!-- view users option -->
                <div class="restfox-option">
                    <div class="option-details">
                        <div class="iconarea">
                            <div class="icon ic-news"></div>
                        </div>

                        <div class="restfox-option-text">
                            <strong>Posts</strong><br>
                            <span>Manage published or drafted posts</span>
                        </div>
                    </div>

                    <label class="toggle">
                        <input type="hidden" name="restfox_show_users" value="0">
                        <input type="checkbox" name="restfox_show_users" value="1" <?php checked(1, $show_users); ?>>
                        <span class="toggle track"></span>
                    </label>
                </div>



                <!-- update config option -->
                <div class="restfox-option">
                    <div class="option-details">
                        <div class="iconarea">
                            <div class="icon ic-config"></div>
                        </div>

                        <div class="restfox-option-text">
                            <strong>Settings</strong><br>
                            <span>Change basic WP settings</span>
                        </div>
                    </div>

                    <label class="toggle">
                        <input type="hidden" name="restfox_change_config" value="0">
                        <input type="checkbox" name="restfox_change_config" value="1"
                            <?php checked(1, $change_config); ?>>
                        <span class="toggle track"></span>
                    </label>
                </div>

            </div>

            <?php submit_button('Update RestFox Settings'); ?>
        </form>

        <!-- footer -->
        <div class="footer">
            <div class="copy">
                <p>&copy; <?= date('Y'); ?> <a href="<?= plugin_info( 'AuthorURI' );?>">Alexander
                        Anastasiadis</a></p>
            </div>

            <div class="links">
                Version <?= plugin_info('Version'); ?>
            </div>
        </div>
    </div>











</div>


<!-- floating buttons -->
<div class="floatings">
    <a href="https://github.com" class="floater">
        <div class="icon-book"></div>
    </a>

    <a href="https://github.com/alexanasgr/restfox" class="floater">
        <div class="icon-github"></div>
    </a>

    <a href="https://github.com" class="floater">
        <div class="icon-firefox"></div>
    </a>

</div>





<?php
    }
}