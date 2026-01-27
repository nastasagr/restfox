<?php

require_once __DIR__ . '/handlers/Themes.php';
require_once __DIR__ . '/handlers/Plugins.php';
require_once __DIR__ . '/handlers/Settings.php';
require_once __DIR__ . '/handlers/Users.php';
require_once __DIR__ . '/handlers/Posts.php';



trait Handlers
{

    use ThemesHandler;
    use PluginsHandler;
    use UsersHandler;
    use PostsHandler;
    use SettingsHandler;
}
