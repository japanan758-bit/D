<?php

use App\Filament\Resources\UserResource;
use App\Filament\Resources\ApiIntegrationResource;
use App\Filament\Widgets\IntegrationStatusWidget;
use App\Filament\Widgets\IntegrationHealthWidget;
use Filament\Pages\Auth\Login;
use Filament\Pages\Dashboard;
use Illuminate\Support\Facades\Route;

return [

    /*
    |--------------------------------------------------------------------------
    | Blade Theme
    |--------------------------------------------------------------------------
    |
    | This is the theme that will be used by default for all Blade views.
    | You can change this to a theme you've built and compiled.
    |
    | Supported themes: "default", "sunset".
    |
    */

    'theme' => env('FILAMENT_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | RTL Support
    |--------------------------------------------------------------------------
    |
    | This option indicates whether or not Filament should enable right-to-left
    | (RTL) support for the interface. This depends on the language used in
    | your application.
    |
    */

    'rtl' => env('FILAMENT_RTL', true),

    /*
    |--------------------------------------------------------------------------
    | Database Notifications
    |--------------------------------------------------------------------------
    |
    | This option enables the database notifications channel for Filament.
    |
    */

    'database_notifications' => [
        'enabled' => env('FILAMENT_DATABASE_NOTIFICATIONS_ENABLED', false),
        'polling_interval' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    |
    | By default, Filament supports broadcasting notifications to the browser
    | via Laravel Echo. You can disable this by setting this to false.
    |
    */

    'broadcasting' => env('FILAMENT_BROADCASTING_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Auto-discovery
    |--------------------------------------------------------------------------
    |
    | Filament will automatically discover certain classes within your project
    | if you are using specific paths. You can customize which paths to scan,
    | or completely disable auto-discovery.
    |
    */

    'auto_discovery' => env('FILAMENT_AUTO_DISCOVERY_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Brand Name
    |--------------------------------------------------------------------------
    |
    | This will be displayed on the login page and in the header of all pages.
    |
    */

    'brand' => env('FILAMENT_BRAND', 'عيادة د. عبدالناصر الأخرس'),

    /*
    |--------------------------------------------------------------------------
    | Dark Mode
    |--------------------------------------------------------------------------
    |
    | By default, this is enabled. You can toggle dark mode by default by
    | setting this to true, or use the `theme:switch` command.
    |
    */

    'dark_mode' => env('FILAMENT_DARK_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | Database Session Driver
    |--------------------------------------------------------------------------
    |
    | If you are using the database session driver, you may configure the
    | name of the table used here.
    |
    */

    'database_session_table' => env('FILAMENT_DATABASE_SESSION_TABLE', 'filament_sessions'),

    /*
    |--------------------------------------------------------------------------
    | Default Avatar Provider
    |--------------------------------------------------------------------------
    |
    | This is the service that will be used to retrieve default avatars if
    | none are stored.
    |
    | Supported: "null", "gravatar"
    |
    */

    'default_avatar_provider' => env('FILAMENT_DEFAULT_AVATAR_PROVIDER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk used by Filament. You can use any of the
    | disks defined in `config/filesystems.php`.
    |
    */

    'default_filesystem_disk' => env('FILAMENT_DEFAULT_FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Disabling Scripts
    |--------------------------------------------------------------------------
    |
    | This array contains a list of script names that will be prevented from
    | running in the browser.
    |
    */

    'disable_scripts' => [
        // 'turbo',
        // 'alpinejs',
    ],

    /*
    |--------------------------------------------------------------------------
    | Disabling Styles
    |--------------------------------------------------------------------------
    |
    | This array contains a list of CSS filenames that will be prevented from
    | loading in the browser.
    |
    */

    'disable_styles' => [
        // 'tom-select',
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    |
    | By default, if the user model implements MustVerifyEmail, the user needs
    | to have verified their email address before accessing Filament. You can
    | disable this behavior by setting this to false.
    |
    */

    'email_verification' => env('FILAMENT_EMAIL_VERIFICATION', false),

    /*
    |--------------------------------------------------------------------------
    | File Upload Theme
    |--------------------------------------------------------------------------
    |
    | This is the theme for the file upload field.
    | Supports: "default", "dropzone"
    |
    */

    'file_upload_theme' => env('FILAMENT_FILE_UPLOAD_THEME', 'dropzone'),

    /*
    |--------------------------------------------------------------------------
    | Font Family
    |--------------------------------------------------------------------------
    |
    | This is the font family used by the theme. You can change this to any
    | string you want.
    |
    */

    'font_family' => env('FILAMENT_FONT_FAMILY', 'ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"'),

    /*
    |--------------------------------------------------------------------------
    | Forms
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the form helper used across Filament.
    |
    */

    'forms' => [
        'components' => [
            'checkbox' => [
                'default' => env('FILAMENT_FORMS_CHECKBOX_DEFAULT', false),
            ],
            'date_time_picker' => [
                'display_format' => env('FILAMENT_FORMS_DATE_TIME_PICKER_DISPLAY_FORMAT', 'd/m/Y H:i'),
                'display_format_24h' => env('FILAMENT_FORMS_DATE_TIME_PICKER_DISPLAY_FORMAT_24H', 'd/m/Y H:i'),
                'first_day_of_week' => (int) env('FILAMENT_FORMS_DATE_TIME_PICKER_FIRST_DAY_OF_WEEK', 6),
                'options' => [
                    'alt_format' => 'Y-m-d H:i:S',
                    'date_format' => 'Y-m-d',
                    'enable_time' => true,
                    'enable_seconds' => false,
                    'time_24hr' => true,
                ],
                'plugins' => [
                    'filter_dates' => [
                        'enabled' => env('FILAMENT_FORMS_DATE_TIME_PICKER_FILTER_DATES_ENABLED', true),
                    ],
                    'months_show_format' => 'M',
                    'range' => [
                        'enabled' => env('FILAMENT_FORMS_DATE_TIME_PICKER_RANGE_ENABLED', false),
                    ],
                    'timezone' => env('FILAMENT_FORMS_DATE_TIME_PICKER_TIMEZONE', null),
                    'week_numbers' => [
                        'enabled' => env('FILAMENT_FORMS_DATE_TIME_PICKER_WEEK_NUMBERS_ENABLED', false),
                    ],
                ],
                'preload_date' => env('FILAMENT_FORMS_DATE_TIME_PICKER_PRELOAD_DATE', false),
            ],
            'file_upload' => [
                'is_editor' => env('FILAMENT_FORMS_FILE_UPLOAD_IS_EDITOR', false),
                'is_recording' => env('FILAMENT_FORMS_FILE_UPLOAD_IS_RECORDING', false),
                'max_upload_size' => env('FILAMENT_FORMS_FILE_UPLOAD_MAX_UPLOAD_SIZE', 1024), // MB
                'parallel_uploads' => env('FILAMENT_FORMS_FILE_UPLOAD_PARALLEL_UPLOADS', 2),
                'placeholder' => env('FILAMENT_FORMS_FILE_UPLOAD_PLACEHOLDER', null),
                'remove_uploaded_file_using_path' => false,
            ],
            'rich_editor' => [
                'toolbar' => [
                    'sticky' => env('FILAMENT_FORMS_RICH_EDITOR_TOOLBAR_STICKY', true),
                ],
            ],
            'select' => [
                'searchable' => env('FILAMENT_FORMS_SELECT_SEARCHABLE', true),
                'search_placeholder' => env('FILAMENT_FORMS_SELECT_SEARCH_PLACEHOLDER', 'بحث...'),
                'search_debounce' => (int) env('FILAMENT_FORMS_SELECT_SEARCH_DEBOUNCE', 350),
            ],
            'tags_input' => [
                'max_items' => env('FILAMENT_FORMS_TAGS_INPUT_MAX_ITEMS', null),
                'placeholder' => env('FILAMENT_FORMS_TAGS_INPUT_PLACEHOLDER', 'أضف عنصر'),
                'type_ahead' => false,
            ],
            'text_input' => [
                'autocomplete' => env('FILAMENT_FORMS_TEXT_INPUT_AUTOCOMPLETE', 'on'),
                'debounce' => (int) env('FILAMENT_FORMS_TEXT_INPUT_DEBOUNCE', 250),
                'prefix_icon_alias' => env('FILAMENT_FORMS_TEXT_INPUT_PREFIX_ICON_ALIAS', 'heroicon-m-magnifying-glass'),
                'suffix_icon_alias' => env('FILAMENT_FORMS_TEXT_INPUT_SUFFIX_ICON_ALIAS', null),
            ],
            'textarea' => [
                'autocomplete' => env('FILAMENT_FORMS_TEXTAREA_AUTOCOMPLETE', 'on'),
                'debounce' => (int) env('FILAMENT_FORMS_TEXTAREA_DEBOUNCE', 250),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the general Filament application.
    |
    */

    'general' => [
        'locale' => env('FILAMENT_LOCALE', 'ar'),
        'timezone' => env('FILAMENT_TIMEZONE', 'Asia/Riyadh'),
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Override
    |--------------------------------------------------------------------------
    |
    | This option enables the HTTP method override functionality for requests.
    | This allows certain frameworks and applications to send PUT and DELETE
    | requests through forms.
    |
    */

    'http_method_override' => env('FILAMENT_HTTP_METHOD_OVERRIDE', false),

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the general layout of Filament pages.
    |
    */

    'layout' => [
        'actions' => [
            'modal' => [
                'alignment' => env('FILAMENT_LAYOUT_ACTIONS_MODAL_ALIGNMENT', 'start'),
            ],
            'breadcrumb' => ' Filament\Resources\Pages\ListRecords\Breadcrumb',
            'max_content_width' => env('FILAMENT_LAYOUT_MAX_CONTENT_WIDTH', 'full'),
            'page_end' => [
                'alignment' => env('FILAMENT_LAYOUT_ACTIONS_PAGE_END_ALIGNMENT', 'end'),
            ],
            'tables' => [
                'search_debounce' => (int) env('FILAMENT_LAYOUT_ACTIONS_TABLES_SEARCH_DEBOUNCE', 350),
            ],
        ],
        'forms' => [
            'require_js' => env('FILAMENT_LAYOUT_FORMS_REQUIRE_JS', false),
        ],
        'sidebar' => [
            'is_collapsible_on_desktop' => env('FILAMENT_LAYOUT_SIDEBAR_IS_COLLAPSIBLE_ON_DESKTOP', false),
            'max_width' => env('FILAMENT_LAYOUT_SIDEBAR_MAX_WIDTH', null),
            'width' => env('FILAMENT_LAYOUT_SIDEBAR_WIDTH', '14rem'),
        ],
        'max_content_width' => env('FILAMENT_LAYOUT_MAX_CONTENT_WIDTH', 'full'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Localization
    |--------------------------------------------------------------------------
    |
    | This is the language that Filament will use for all text in the UI.
    |
    */

    'locale' => env('FILAMENT_LOCALE', 'ar'),

    /*
    |--------------------------------------------------------------------------
    | Login Page
    |--------------------------------------------------------------------------
    |
    | This option configures the login page that Filament will use for
    | authentication.
    |
    */

    'login' => [
        'authentication_url' => env('FILAMENT_LOGIN_URL', '/admin/login'),
        'remember_me' => true,
        'use_email' => env('FILAMENT_LOGIN_USE_EMAIL', true),
        'username' => env('FILAMENT_LOGIN_USERNAME', 'email'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | These are the middleware that Filament will attach to routes.
    |
    */

    'middleware' => [
        'auth' => [
            'web',
        ],
        'base' => [
            \App\Http\Middleware\HandleInertiaRequests::class,
        ],
        'authenticate' => [
            'web',
        ],
        'register' => [
            'web',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    |
    | This is the navigation configuration for the sidebar in the admin panel.
    |
    */

    'navigation' => [
        'collapsible' => env('FILAMENT_NAVIGATION_COLLAPSIBLE', false),
        'groups' => [],
        'max_depth' => env('FILAMENT_NAVIGATION_MAX_DEPTH', 3),
        'sort' => env('FILAMENT_NAVIGATION_SORT', 0),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | This is the configuration for all notification related functionality.
    |
    */

    'notifications' => [
        'enabled' => env('FILAMENT_NOTIFICATIONS_ENABLED', true),
        'database' => [
            'enabled' => env('FILAMENT_NOTIFICATIONS_DATABASE_ENABLED', false),
            'polling_interval' => '30s',
        ],
        'duration' => [
            'default' => env('FILAMENT_NOTIFICATIONS_DURATION', 5000),
            'persistent' => env('FILAMENT_NOTIFICATIONS_DURATION_PERSISTENT', null),
        ],
        'theme' => env('FILAMENT_NOTIFICATIONS_THEME', 'default'), // "default" or "sunset"
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | This is the default number of records shown per page.
    |
    */

    'pagination' => [
        'default_records_per_page' => (int) env('FILAMENT_PAGINATION_DEFAULT_RECORDS_PER_PAGE', 25),
        'max_records_per_page' => (int) env('FILAMENT_PAGINATION_MAX_RECORDS_PER_PAGE', 100),
        'records_per_page_options' => [10, 25, 50, 100],
        'use_query_string_for_scopes' => env('FILAMENT_PAGINATION_USE_QUERY_STRING_FOR_SCOPES', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Panel Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the default panel used for Filament resources.
    |
    */

    'panels' => [
        'admin' => [
            'pages' => [
                'dashboard' => [
                    'max_content_width' => env('FILAMENT_PANELS_ADMIN_PAGES_DASHBOARD_MAX_CONTENT_WIDTH', null),
                    'widgets' => [
                        App\Filament\Widgets\IntegrationStatusWidget::class,
                        App\Filament\Widgets\IntegrationHealthWidget::class,
                    ],
                ],
                'auth' => [
                    'login' => \Filament\Pages\Auth\Login::class,
                    'register' => \Filament\Pages\Auth\Register::class,
                    'profile' => \Filament\Pages\Auth\EditProfile::class,
                ],
            ],
            'resources' => [
                'pages' => [
                    'list_records' => [
                        'breadcrumb' => env('FILAMENT_PANELS_ADMIN_RESOURCES_PAGES_LIST_RECORDS_BREADCRUMB', null),
                    ],
                    'create_record' => [
                        'breadcrumb' => env('FILAMENT_PANELS_ADMIN_RESOURCES_PAGES_CREATE_RECORD_BREADCRUMB', null),
                    ],
                    'edit_record' => [
                        'breadcrumb' => env('FILAMENT_PANELS_ADMIN_RESOURCES_PAGES_EDIT_RECORD_BREADCRUMB', null),
                        'max_content_width' => env('FILAMENT_PANELS_ADMIN_RESOURCES_PAGES_EDIT_RECORD_MAX_CONTENT_WIDTH', 'full'),
                    ],
                ],
            ],
            'widgets' => [
                'dashboard' => [
                    'columns' => [
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                    ],
                    'column_span' => [
                        'sm' => 1,
                        'md' => 'full',
                        'lg' => 'full',
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugin Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the plugins that Filament will use for the
    | application.
    |
    */

    'plugins' => [
        // \Your\Plugin\Namespace::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Rendering Theme
    |--------------------------------------------------------------------------
    |
    | This is the theme that will be used for rendering the main application.
    | You can change this to "tailwindcss" or "bootstrap".
    |
    | Supported themes: "tailwindcss"
    |
    */

    'rendering_theme' => env('FILAMENT_RENDERING_THEME', 'tailwindcss'),

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | This is the repository configuration used by Filament.
    |
    */

    'repositories' => [
        'enabled' => env('FILAMENT_REPOSITORIES_ENABLED', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Resources Configuration
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the resource system used by Filament.
    |
    */

    'resources' => [
        'pages' => [
            'list_records' => [
                'breadcrumb' => env('FILAMENT_RESOURCES_PAGES_LIST_RECORDS_BREADCRUMB', null),
            ],
            'create_record' => [
                'breadcrumb' => env('FILAMENT_RESOURCES_PAGES_CREATE_RECORD_BREADCRUMB', null),
            ],
            'edit_record' => [
                'breadcrumb' => env('FILAMENT_RESOURCES_PAGES_EDIT_RECORD_BREADCRUMB', null),
                'max_content_width' => env('FILAMENT_RESOURCES_PAGES_EDIT_RECORD_MAX_CONTENT_WIDTH', 'full'),
            ],
        ],
        'status_column' => [
            'align' => env('FILAMENT_RESOURCES_STATUS_COLUMN_ALIGN', 'right'),
        ],
        'tables' => [
            'computed_column' => [
                'alignment' => env('FILAMENT_RESOURCES_TABLES_COMPUTED_COLUMN_ALIGNMENT', 'right'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sanctum
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the Sanctum authentication used by Filament.
    |
    */

    'sanctum' => [
        'permissions' => [
            'enabled' => env('FILAMENT_SANCTUM_PERMISSIONS_ENABLED', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the search functionality used by Filament.
    |
    */

    'search' => [
        'debounce' => (int) env('FILAMENT_SEARCH_DEBOUNCE', 350),
        'is_enabled' => env('FILAMENT_SEARCH_ENABLED', true),
        'meanwhile_letter_count' => (int) env('FILAMENT_SEARCH_MEANWHILE_LETTER_COUNT', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Skip Link
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the skip link that allows users to jump
    | directly to the main content area of the page.
    |
    */

    'skip_link' => [
        'enabled' => env('FILAMENT_SKIP_LINK_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | SPAs
    |--------------------------------------------------------------------------
    |
    | This option configures if the admin panel should be a single-page
    | application (SPA).
    |
    */

    'spa' => [
        'enabled' => env('FILAMENT_SPA_ENABLED', false),
        'middleware' => [
            'base' => [
                \App\Http\Middleware\HandleInertiaRequests::class,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Stack on Mobile
    |--------------------------------------------------------------------------
    |
    | This option configures if the actions in the header should stack on mobile.
    |
    */

    'stack_on_mobile' => env('FILAMENT_STACK_ON_MOBILE', false),

    /*
    |--------------------------------------------------------------------------
    | Static Background
    |--------------------------------------------------------------------------
    |
    | This option enables the static background for the admin panel.
    |
    */

    'static_background' => env('FILAMENT_STATIC_BACKGROUND', true),

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the table helper used across Filament.
    |
    */

    'tables' => [
        'columns' => [
            'sticky' => [
                'actions' => env('FILAMENT_TABLES_COLUMNS_STICKY_ACTIONS', false),
                'footer' => env('FILAMENT_TABLES_COLUMNS_STICKY_FOOTER', false),
                'header' => env('FILAMENT_TABLES_COLUMNS_STICKY_HEADER', true),
            ],
        ],
        'filters' => [
            'query_string' => [
                'enabled' => env('FILAMENT_TABLES_FILTERS_QUERY_STRING_ENABLED', true),
            ],
        ],
        'pagination' => [
            'default_records_per_page' => (int) env('FILAMENT_TABLES_PAGINATION_DEFAULT_RECORDS_PER_PAGE', 25),
            'has_global_search' => env('FILAMENT_TABLES_PAGINATION_HAS_GLOBAL_SEARCH', true),
        ],
        'records' => [
            'per_page' => [
                'options' => [10, 25, 50, 100],
                'default' => (int) env('FILAMENT_TABLES_RECORDS_PER_PAGE_DEFAULT', 25),
            ],
        ],
        'search' => [
            'fields' => [],
            'is_enabled' => env('FILAMENT_TABLES_SEARCH_ENABLED', true),
            'placeholder' => env('FILAMENT_TABLES_SEARCH_PLACEHOLDER', 'بحث...'),
        ],
        'sorting' => [
            'column' => env('FILAMENT_TABLES_SORTING_COLUMN', 'created_at'),
            'direction' => env('FILAMENT_TABLES_SORTING_DIRECTION', 'desc'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | This is the theme that will be used for rendering the admin panel.
    |
    */

    'theme' => env('FILAMENT_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Topbar
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the topbar in the admin panel.
    |
    */

    'topbar' => [
        'brand' => env('FILAMENT_TOPBAR_BRAND', 'عيادة د. عبدالناصر الأخرس'),
        'color' => env('FILAMENT_TOPBAR_COLOR', 'primary'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Warnings
    |--------------------------------------------------------------------------
    |
    | This option configures if Filament should show warnings.
    |
    */

    'warnings' => [
        'enabled' => env('FILAMENT_WARNINGS_ENABLED', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the widgets used in the admin panel.
    |
    */

    'widgets' => [
        'dashboard' => [
            'columns' => [
                'sm' => 1,
                'md' => 2,
                'lg' => 3,
            ],
        ],
        'forms' => [
            'card' => [
                'component' => 'filament.forms::components.card',
            ],
        ],
        'tables' => [
            'table' => [
                'component' => 'filament.tables::components.table',
            ],
        ],
    ],
];