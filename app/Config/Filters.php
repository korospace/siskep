<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

use App\Filters\ApiGuard;
use App\Filters\ApiGuardAdmin;
use App\Filters\ApiGuardAdminKabag;
use App\Filters\ApiGuardAsn;
use App\Filters\ApiGuardNonAsn;
use App\Filters\Dashboard;
use App\Filters\DashboardLogged;
use App\Filters\DashboardAsn;
use App\Filters\DashboardNonAsn;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'throttle'           => \App\Filters\Throttle::class,
        'ApiGuard'           => ApiGuard::class,
        'ApiGuardAdmin'      => ApiGuardAdmin::class,
        'ApiGuardAdminKabag' => ApiGuardAdminKabag::class,
        'ApiGuardAsn'        => ApiGuardAsn::class,
        'ApiGuardNonAsn'     => ApiGuardNonAsn::class,
        'Dashboard'          => Dashboard::class,
        'DashboardLogged'    => DashboardLogged::class,
        'DashboardAsn'       => DashboardAsn::class,
        'DashboardNonAsn'    => DashboardNonAsn::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [
        'get'    => ['throttle'],
        'post'   => ['throttle'],
        'put'    => ['throttle'],
        'delete' => ['throttle'],
    ];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
