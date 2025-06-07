<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tiêu đề trang (Title)
    |--------------------------------------------------------------------------
    */
    'title' => 'Hệ Thống Quản Lý Nhạc',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */
    'logo' => '<b>Music</b>Manager',
    'logo_img' => 'vendor/adminlte/dist/img/LogoWebSite.png', // Đường dẫn logo
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',

    /*
    |--------------------------------------------------------------------------
    | Menu Sidebar
    |--------------------------------------------------------------------------
    */
    'menu' => [
        // Header
        ['header' => 'QUẢN LÝ HỆ THỐNG'],

        // Dashboard
        [
            'text' => 'Bảng điều khiển',
            'url'  => 'admin',
            'icon' => 'fas fa-tachometer-alt',
        ],

        // Quản lý Người dùng
        [
            'text' => 'Quản lý Người dùng',
            'url'  => 'admin/users',
            'icon' => 'fas fa-users',
        ],

        // Quản lý Nghệ sĩ
        [
            'text' => 'Quản lý Nghệ sĩ',
            'url'  => 'admin/artists',
            'icon' => 'fas fa-microphone',
        ],

        // Quản lý Bài hát
        [
            'text' => 'Quản lý Bài hát',
            'url'  => 'admin/songs',
            'icon' => 'fas fa-music',
        ],

        // Quản lý Thể loại
        [
            'text' => 'Quản lý Thể loại',
            'url'  => 'admin/genres',
            'icon' => 'fas fa-tags',
        ],

        // Quản lý Danh sách phát
        [
            'text' => 'Quản lý Danh sách phát',
            'url'  => 'admin/playlists',
            'icon' => 'fas fa-list',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout và Thiết kế
    |--------------------------------------------------------------------------
    */
    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,  // Sidebar cố định
    'layout_fixed_navbar' => true,   // Navbar cố định
    'layout_fixed_footer' => true,   // Footer cố định

    /*
    |--------------------------------------------------------------------------
    | Plugin
    |--------------------------------------------------------------------------
    */
    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css',
                ],
            ],
        ],
    ],
];

