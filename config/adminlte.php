<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'VoucherADV',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Voucher</b>ADV',

    'logo_mini' => '<b>V</b>ADV',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'BOOKING',
        [
            'text' => 'Dash Board',
            'url' => 'dashboard',
            'icon' => 'dashboard',
        ],
        [
            'text' => 'List Booking',
            'url' => 'booking/list',
            'icon' => 'list-ol',
        ],
        [
            'text' => 'Add Booking',
            'icon' => 'plus-square',
            'submenu' => [
                [
                    'text' => 'Boat',
                    'url' => 'booking/boat',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Bus',
                    'url' => 'booking/bus',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Joint Ticket',
                    'url' => 'booking/jointTicket',
                    'icon_color' => 'aqua',
                ],
            ],
        ],
        'DAILY SALE CASH',
        [
            'text' => 'List Daily Sale Cash',
            'url' => 'daily/cash/list',
            'icon' => 'list-ol',
        ],
        [
            'text' => 'Add Daily Sale Cash',
            'icon' => 'plus-square',
            'submenu' => [
                [
                    'text' => 'Boat',
                    'url' => 'daily/cash/boat',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Bus',
                    'url' => 'daily/cash/bus',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Joint Ticket',
                    'url' => 'daily/cash/jointTicket',
                    'icon_color' => 'aqua',
                ],
            ],
        ],
        'DAILY SALE CREDIT',
        [
            'text' => 'List Daily Sale Credit',
            'url' => 'daily/credit/list',
            'icon' => 'list-ol',
        ],
        [
            'text' => 'Add Daily Sale Credit',
            'icon' => 'plus-square',
            'submenu' => [
                [
                    'text' => 'Boat',
                    'url' => 'daily/credit/boat',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Bus',
                    'url' => 'daily/credit/bus',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Joint Ticket',
                    'url' => 'daily/credit/jointTicket',
                    'icon_color' => 'aqua',
                ],
            ],
        ],
        'INVOICE',
        [
            'text' => 'List Invoice',
            'url' => 'invoice/list',
            'icon' => 'list-ol',
        ],
        [
            'text' => 'Add Invoice',
            'url' => 'invoice/add',
            'icon' => 'plus-square',
        ],
        'DAILY SALE CLEAR CREDIT',
        [
            'text' => 'List D/S Clear Credit',
            'url' => 'clear/list',
            'icon' => 'list-ol',
        ],
        [
            'text' => 'Add D/S Clear Credit',
            'icon' => 'plus-square',
            'submenu' => [
                [
                    'text' => 'Cash',
                    'url' => 'clear/cash',
                    'icon_color' => 'aqua',
                ],
                [
                    'text' => 'Check',
                    'url' => 'clear/check',
                    'icon_color' => 'aqua',
                ],
            ],
        ],
        'ADMINISTRATOR',
        [
            'text' => 'Manage Admin',
            'icon' => 'users',
            'submenu' => [
                [
                    'text' => 'Agent',
                    'url' => 'admin/agent',
                    'icon' => 'users',
                ],
                [
                    'text' => 'Member',
                    'url' => 'admin/member',
                    'icon' => 'user-plus',
                ],
                [
                    'text' => 'Logs',
                    'url' => 'log-viewer',
                    'icon' => 'search-plus',
                ],
            ],
        ],
        'CONFIGURATION',
        [
            'text' => 'Manage Config',
            'icon' => 'gears',
            'submenu' => [
                [
                    'text' => 'Branch',
                    'url' => 'config/branch',
                    'icon' => 'gears',
                ],
                [
                    'text' => 'Route',
                    'url' => 'config/route',
                    'icon' => 'gears',
                ],
                [
                    'text' => 'Destination',
                    'url' => 'config/destination',
                    'icon' => 'gears',
                ],
                [
                    'text' => 'Best Seller',
                    'url' => 'config/bestSeller',
                    'icon' => 'gears',
                ],
                [
                    'text' => 'Time',
                    'url' => 'config/time',
                    'icon' => 'gears',
                ],
                [
                    'text' => 'Bank',
                    'url' => 'config/bank',
                    'icon' => 'gears',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
//        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        App\Filters\MenuFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2' => true,
        'chartjs' => true,
    ],
];
