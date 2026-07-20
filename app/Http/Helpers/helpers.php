<?php

if (!function_exists('setSidebarActive')) {
    /**
     * Set the sidebar menu item as active.
     */
    function setSidebarActive(array $routes): ?string
    {
        if (request()->routeIs($routes)) {
            return 'active';
        }

        return null;
    }
}
