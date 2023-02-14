<?php return array (
    'app' =>
        array (
            'name' => 'Laravel',
            'env' => 'local',
            'debug' => false,
            'url' => 'http://localhost',
            'asset_url' => NULL,
            'timezone' => 'Asia/Almaty',
            'locale' => 'ru',
            'fallback_locale' => 'kk',
            'faker_locale' => 'en_US',
            'key' => 'base64:E6fS0xm+mT8FsKC68N+Ysrb7PyhSCfLGS2beHO62obM=',
            'cipher' => 'AES-256-CBC',
            'providers' =>
                array (
                    0 => 'Illuminate\\Auth\\AuthServiceProvider',
                    1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
                    2 => 'Illuminate\\Bus\\BusServiceProvider',
                    3 => 'Illuminate\\Cache\\CacheServiceProvider',
                    4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
                    5 => 'Illuminate\\Cookie\\CookieServiceProvider',
                    6 => 'Illuminate\\Database\\DatabaseServiceProvider',
                    7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
                    8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
                    9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
                    10 => 'Illuminate\\Hashing\\HashServiceProvider',
                    11 => 'Illuminate\\Mail\\MailServiceProvider',
                    12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
                    13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
                    14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
                    15 => 'Illuminate\\Queue\\QueueServiceProvider',
                    16 => 'Illuminate\\Redis\\RedisServiceProvider',
                    17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
                    18 => 'Illuminate\\Session\\SessionServiceProvider',
                    19 => 'Illuminate\\Translation\\TranslationServiceProvider',
                    20 => 'Illuminate\\Validation\\ValidationServiceProvider',
                    21 => 'Illuminate\\View\\ViewServiceProvider',
                    22 => 'Intervention\\Image\\ImageServiceProvider',
                    23 => 'App\\Providers\\AppServiceProvider',
                    24 => 'App\\Providers\\AuthServiceProvider',
                    25 => 'App\\Providers\\EventServiceProvider',
                    26 => 'App\\Providers\\RouteServiceProvider',
                ),
            'aliases' =>
                array (
                    'App' => 'Illuminate\\Support\\Facades\\App',
                    'Arr' => 'Illuminate\\Support\\Arr',
                    'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
                    'Auth' => 'Illuminate\\Support\\Facades\\Auth',
                    'Blade' => 'Illuminate\\Support\\Facades\\Blade',
                    'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
                    'Bus' => 'Illuminate\\Support\\Facades\\Bus',
                    'Cache' => 'Illuminate\\Support\\Facades\\Cache',
                    'Config' => 'Illuminate\\Support\\Facades\\Config',
                    'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
                    'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
                    'DB' => 'Illuminate\\Support\\Facades\\DB',
                    'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
                    'Event' => 'Illuminate\\Support\\Facades\\Event',
                    'File' => 'Illuminate\\Support\\Facades\\File',
                    'Gate' => 'Illuminate\\Support\\Facades\\Gate',
                    'Hash' => 'Illuminate\\Support\\Facades\\Hash',
                    'Lang' => 'Illuminate\\Support\\Facades\\Lang',
                    'Log' => 'Illuminate\\Support\\Facades\\Log',
                    'Mail' => 'Illuminate\\Support\\Facades\\Mail',
                    'Notification' => 'Illuminate\\Support\\Facades\\Notification',
                    'Password' => 'Illuminate\\Support\\Facades\\Password',
                    'Queue' => 'Illuminate\\Support\\Facades\\Queue',
                    'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
                    'Redis' => 'Illuminate\\Support\\Facades\\Redis',
                    'Request' => 'Illuminate\\Support\\Facades\\Request',
                    'Response' => 'Illuminate\\Support\\Facades\\Response',
                    'Route' => 'Illuminate\\Support\\Facades\\Route',
                    'Schema' => 'Illuminate\\Support\\Facades\\Schema',
                    'Session' => 'Illuminate\\Support\\Facades\\Session',
                    'Storage' => 'Illuminate\\Support\\Facades\\Storage',
                    'Str' => 'Illuminate\\Support\\Str',
                    'URL' => 'Illuminate\\Support\\Facades\\URL',
                    'Validator' => 'Illuminate\\Support\\Facades\\Validator',
                    'View' => 'Illuminate\\Support\\Facades\\View',
                    'Image' => 'Intervention\\Image\\Facades\\Image',
                    'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
                ),
        ),
    'auth' =>
        array (
            'defaults' =>
                array (
                    'guard' => 'web',
                    'passwords' => 'users',
                ),
            'guards' =>
                array (
                    'web' =>
                        array (
                            'driver' => 'session',
                            'provider' => 'users',
                        ),
                    'api' =>
                        array (
                            'driver' => 'token',
                            'provider' => 'users',
                            'hash' => false,
                        ),
                ),
            'providers' =>
                array (
                    'users' =>
                        array (
                            'driver' => 'eloquent',
                            'model' => 'App\\Users',
                        ),
                ),
            'passwords' =>
                array (
                    'users' =>
                        array (
                            'provider' => 'users',
                            'table' => 'password_resets',
                            'expire' => 60,
                        ),
                ),
        ),
    'broadcasting' =>
        array (
            'default' => 'log',
            'connections' =>
                array (
                    'pusher' =>
                        array (
                            'driver' => 'pusher',
                            'key' => '',
                            'secret' => '',
                            'app_id' => '',
                            'options' =>
                                array (
                                    'cluster' => 'mt1',
                                    'encrypted' => true,
                                ),
                        ),
                    'redis' =>
                        array (
                            'driver' => 'redis',
                            'connection' => 'default',
                        ),
                    'log' =>
                        array (
                            'driver' => 'log',
                        ),
                    'null' =>
                        array (
                            'driver' => 'null',
                        ),
                ),
        ),
    'cache' =>
        array (
            'default' => 'array',
            'stores' =>
                array (
                    'apc' =>
                        array (
                            'driver' => 'apc',
                        ),
                    'array' =>
                        array (
                            'driver' => 'array',
                        ),
                    'database' =>
                        array (
                            'driver' => 'database',
                            'table' => 'cache',
                            'connection' => NULL,
                        ),
                    'file' =>
                        array (
                            'driver' => 'file',
                            'path' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/framework/cache/data',
                        ),
                    'memcached' =>
                        array (
                            'driver' => 'memcached',
                            'persistent_id' => NULL,
                            'sasl' =>
                                array (
                                    0 => NULL,
                                    1 => NULL,
                                ),
                            'options' =>
                                array (
                                ),
                            'servers' =>
                                array (
                                    0 =>
                                        array (
                                            'host' => '127.0.0.1',
                                            'port' => 11211,
                                            'weight' => 100,
                                        ),
                                ),
                        ),
                    'redis' =>
                        array (
                            'driver' => 'redis',
                            'connection' => 'cache',
                        ),
                    'dynamodb' =>
                        array (
                            'driver' => 'dynamodb',
                            'key' => '',
                            'secret' => '',
                            'region' => 'us-east-1',
                            'table' => 'cache',
                        ),
                ),
            'prefix' => 'laravel_cache',
        ),
    'database' =>
        array (
            'default' => 'mysql',
            'connections' =>
                array (
                    'sqlite' =>
                        array (
                            'driver' => 'sqlite',
                            'database' => 'n_egemen',
                            'prefix' => '',
                            'foreign_key_constraints' => true,
                        ),
                    'mysql' =>
                        array (
                            'driver' => 'mysql',
                            'host' => '127.0.0.1',
                            'port' => '3306',
                            'database' => 'n_egemen',
                            'username' => 'new_user',
                            'password' => 'egemenE789N',
                            'unix_socket' => '',
                            'charset' => 'utf8mb4',
                            'collation' => 'utf8mb4_unicode_ci',
                            'prefix' => '',
                            'prefix_indexes' => true,
                            'strict' => false,
                            'engine' => NULL,
                            'options' =>
                                array (
                                    0 => true,
                                ),
                        ),
                    'mysql2' =>
                        array (
                            'driver' => 'mysql',
                            'host' => '127.0.0.1',
                            'port' => '3306',
                            'database' => 'wptp',
                            'username' => 'new_user',
                            'password' => 'egemenE789N',
                            'unix_socket' => '',
                            'charset' => 'utf8mb4',
                            'collation' => 'utf8mb4_unicode_ci',
                            'prefix' => '',
                            'prefix_indexes' => true,
                            'strict' => false,
                            'engine' => NULL,
                            'options' =>
                                array (
                                ),
                        ),
                    'pgsql' =>
                        array (
                            'driver' => 'pgsql',
                            'host' => '127.0.0.1',
                            'port' => '3306',
                            'database' => 'n_egemen',
                            'username' => 'new_user',
                            'password' => 'egemenE789N',
                            'charset' => 'utf8',
                            'prefix' => '',
                            'prefix_indexes' => true,
                            'schema' => 'public',
                            'sslmode' => 'prefer',
                        ),
                    'sqlsrv' =>
                        array (
                            'driver' => 'sqlsrv',
                            'host' => '127.0.0.1',
                            'port' => '3306',
                            'database' => 'n_egemen',
                            'username' => 'new_user',
                            'password' => 'egemenE789N',
                            'charset' => 'utf8',
                            'prefix' => '',
                            'prefix_indexes' => true,
                        ),
                ),
            'migrations' => 'migrations',
            'redis' =>
                array (
                    'client' => 'predis',
                    'options' =>
                        array (
                            'cluster' => 'predis',
                        ),
                    'default' =>
                        array (
                            'host' => '127.0.0.1',
                            'password' => NULL,
                            'port' => '6379',
                            'database' => 0,
                        ),
                    'cache' =>
                        array (
                            'host' => '127.0.0.1',
                            'password' => NULL,
                            'port' => '6379',
                            'database' => 1,
                        ),
                ),
        ),
    'filesystems' =>
        array (
            'default' => 'local',
            'cloud' => 's3',
            'disks' =>
                array (
                    'local' =>
                        array (
                            'driver' => 'local',
                            'root' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/app',
                        ),
                    'image' =>
                        array (
                            'driver' => 'local',
                            'root' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/app/image',
                        ),
                    'public' =>
                        array (
                            'driver' => 'local',
                            'root' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/app/public',
                        ),
                    'audio' =>
                        array (
                            'driver' => 'local',
                            'root' => '/var/www/egemen/data/www/laravel/egemen.kz/public/audio',
                            'url' => 'http://localhost/storage',
                            'visibility' => 'public',
                        ),
                    's3' =>
                        array (
                            'driver' => 's3',
                            'key' => '',
                            'secret' => '',
                            'region' => 'us-east-1',
                            'bucket' => '',
                            'url' => NULL,
                        ),
                    'pdfs' =>
                        array (
                            'driver' => 'local',
                            'root' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/app/pdfs',
                        ),
                ),
        ),
    'hashing' =>
        array (
            'driver' => 'bcrypt',
            'bcrypt' =>
                array (
                    'rounds' => 10,
                ),
            'argon' =>
                array (
                    'memory' => 1024,
                    'threads' => 2,
                    'time' => 2,
                ),
        ),
    'logging' =>
        array (
            'default' => 'stack',
            'channels' =>
                array (
                    'stack' =>
                        array (
                            'driver' => 'stack',
                            'channels' =>
                                array (
                                    0 => 'daily',
                                ),
                            'ignore_exceptions' => false,
                        ),
                    'single' =>
                        array (
                            'driver' => 'single',
                            'path' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/logs/laravel.log',
                            'level' => 'debug',
                        ),
                    'daily' =>
                        array (
                            'driver' => 'daily',
                            'path' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/logs/laravel.log',
                            'level' => 'debug',
                            'days' => 14,
                        ),
                    'slack' =>
                        array (
                            'driver' => 'slack',
                            'url' => NULL,
                            'username' => 'Laravel Log',
                            'emoji' => ':boom:',
                            'level' => 'critical',
                        ),
                    'papertrail' =>
                        array (
                            'driver' => 'monolog',
                            'level' => 'debug',
                            'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
                            'handler_with' =>
                                array (
                                    'host' => NULL,
                                    'port' => NULL,
                                ),
                        ),
                    'stderr' =>
                        array (
                            'driver' => 'monolog',
                            'handler' => 'Monolog\\Handler\\StreamHandler',
                            'formatter' => NULL,
                            'with' =>
                                array (
                                    'stream' => 'php://stderr',
                                ),
                        ),
                    'syslog' =>
                        array (
                            'driver' => 'syslog',
                            'level' => 'debug',
                        ),
                    'errorlog' =>
                        array (
                            'driver' => 'errorlog',
                            'level' => 'debug',
                        ),
                ),
        ),
    'mail' =>
        array (
            'driver' => 'mail',
            'host' => 'mail.egemen.kz',
            'port' => '25',
            'from' =>
                array (
                    'address' => 'noreply@egemen.kz',
                    'name' => 'admin',
                ),
            'encryption' => 'ssl',
            'username' => 'noreply@egemen.kz',
            'password' => 'Vkl5p31@',
            'sendmail' => '/usr/sbin/sendmail -bs',
            'markdown' =>
                array (
                    'theme' => 'default',
                    'paths' =>
                        array (
                            0 => '/var/www/egemen/data/www/laravel/egemen.kz/resources/views/vendor/mail',
                        ),
                ),
            'log_channel' => NULL,
        ),
    'queue' =>
        array (
            'default' => 'sync',
            'connections' =>
                array (
                    'sync' =>
                        array (
                            'driver' => 'sync',
                        ),
                    'database' =>
                        array (
                            'driver' => 'database',
                            'table' => 'jobs',
                            'queue' => 'default',
                            'retry_after' => 90,
                        ),
                    'beanstalkd' =>
                        array (
                            'driver' => 'beanstalkd',
                            'host' => 'localhost',
                            'queue' => 'default',
                            'retry_after' => 90,
                            'block_for' => 0,
                        ),
                    'sqs' =>
                        array (
                            'driver' => 'sqs',
                            'key' => '',
                            'secret' => '',
                            'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
                            'queue' => 'your-queue-name',
                            'region' => 'us-east-1',
                        ),
                    'redis' =>
                        array (
                            'driver' => 'redis',
                            'connection' => 'default',
                            'queue' => 'default',
                            'retry_after' => 90,
                            'block_for' => NULL,
                        ),
                ),
            'failed' =>
                array (
                    'database' => 'mysql',
                    'table' => 'failed_jobs',
                ),
        ),
    'scout' =>
        array (
            'driver' => 'algolia',
            'prefix' => '',
            'queue' => false,
            'chunk' =>
                array (
                    'searchable' => 500,
                    'unsearchable' => 500,
                ),
            'soft_delete' => false,
            'algolia' =>
                array (
                    'id' => '',
                    'secret' => '',
                ),
        ),
    'services' =>
        array (
            'mailgun' =>
                array (
                    'domain' => NULL,
                    'secret' => NULL,
                    'endpoint' => 'api.mailgun.net',
                ),
            'postmark' =>
                array (
                    'token' => NULL,
                ),
            'ses' =>
                array (
                    'key' => '',
                    'secret' => '',
                    'region' => 'us-east-1',
                ),
            'sparkpost' =>
                array (
                    'secret' => NULL,
                ),
            'stripe' =>
                array (
                    'model' => 'App\\Models\\Users',
                    'key' => NULL,
                    'secret' => NULL,
                    'webhook' =>
                        array (
                            'secret' => NULL,
                            'tolerance' => 300,
                        ),
                ),
        ),
    'session' =>
        array (
            'driver' => 'redis',
            'lifetime' => '12000',
            'expire_on_close' => false,
            'encrypt' => false,
            'files' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/framework/sessions',
            'connection' => NULL,
            'table' => 'sessions',
            'store' => NULL,
            'lottery' =>
                array (
                    0 => 2,
                    1 => 100,
                ),
            'cookie' => 'laravel_session',
            'path' => '/',
            'domain' => NULL,
            'secure' => false,
            'http_only' => true,
            'same_site' => NULL,
        ),
    'view' =>
        array (
            'paths' =>
                array (
                    0 => '/var/www/egemen/data/www/laravel/egemen.kz/resources/views',
                ),
            'compiled' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/framework/views',
        ),
    'debugbar' =>
        array (
            'enabled' => NULL,
            'except' =>
                array (
                    0 => 'telescope*',
                    1 => 'horizon*',
                ),
            'storage' =>
                array (
                    'enabled' => true,
                    'driver' => 'file',
                    'path' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/debugbar',
                    'connection' => NULL,
                    'provider' => '',
                ),
            'include_vendors' => true,
            'capture_ajax' => true,
            'add_ajax_timing' => false,
            'error_handler' => false,
            'clockwork' => false,
            'collectors' =>
                array (
                    'phpinfo' => true,
                    'messages' => true,
                    'time' => true,
                    'memory' => true,
                    'exceptions' => true,
                    'log' => true,
                    'db' => true,
                    'views' => true,
                    'route' => true,
                    'auth' => false,
                    'gate' => true,
                    'session' => true,
                    'symfony_request' => true,
                    'mail' => true,
                    'laravel' => false,
                    'events' => false,
                    'default_request' => false,
                    'logs' => false,
                    'files' => false,
                    'config' => false,
                    'cache' => false,
                    'models' => true,
                    'livewire' => true,
                ),
            'options' =>
                array (
                    'auth' =>
                        array (
                            'show_name' => true,
                        ),
                    'db' =>
                        array (
                            'with_params' => true,
                            'backtrace' => true,
                            'backtrace_exclude_paths' =>
                                array (
                                ),
                            'timeline' => false,
                            'explain' =>
                                array (
                                    'enabled' => false,
                                    'types' =>
                                        array (
                                            0 => 'SELECT',
                                        ),
                                ),
                            'hints' => false,
                        ),
                    'mail' =>
                        array (
                            'full_log' => false,
                        ),
                    'views' =>
                        array (
                            'data' => false,
                        ),
                    'route' =>
                        array (
                            'label' => true,
                        ),
                    'logs' =>
                        array (
                            'file' => NULL,
                        ),
                    'cache' =>
                        array (
                            'values' => true,
                        ),
                ),
            'inject' => true,
            'route_prefix' => '_debugbar',
            'route_domain' => NULL,
            'theme' => 'auto',
        ),
    'debug-server' =>
        array (
            'host' => 'tcp://127.0.0.1:9912',
        ),
    'image' =>
        array (
            'driver' => 'gd',
        ),
    'excel' =>
        array (
            'exports' =>
                array (
                    'chunk_size' => 1000,
                    'pre_calculate_formulas' => false,
                    'strict_null_comparison' => false,
                    'csv' =>
                        array (
                            'delimiter' => ',',
                            'enclosure' => '"',
                            'line_ending' => '
',
                            'use_bom' => false,
                            'include_separator_line' => false,
                            'excel_compatibility' => false,
                            'output_encoding' => '',
                        ),
                    'properties' =>
                        array (
                            'creator' => '',
                            'lastModifiedBy' => '',
                            'title' => '',
                            'description' => '',
                            'subject' => '',
                            'keywords' => '',
                            'category' => '',
                            'manager' => '',
                            'company' => '',
                        ),
                ),
            'imports' =>
                array (
                    'read_only' => true,
                    'ignore_empty' => false,
                    'heading_row' =>
                        array (
                            'formatter' => 'slug',
                        ),
                    'csv' =>
                        array (
                            'delimiter' => NULL,
                            'enclosure' => '"',
                            'escape_character' => '\\',
                            'contiguous' => false,
                            'input_encoding' => 'UTF-8',
                        ),
                    'properties' =>
                        array (
                            'creator' => '',
                            'lastModifiedBy' => '',
                            'title' => '',
                            'description' => '',
                            'subject' => '',
                            'keywords' => '',
                            'category' => '',
                            'manager' => '',
                            'company' => '',
                        ),
                ),
            'extension_detector' =>
                array (
                    'xlsx' => 'Xlsx',
                    'xlsm' => 'Xlsx',
                    'xltx' => 'Xlsx',
                    'xltm' => 'Xlsx',
                    'xls' => 'Xls',
                    'xlt' => 'Xls',
                    'ods' => 'Ods',
                    'ots' => 'Ods',
                    'slk' => 'Slk',
                    'xml' => 'Xml',
                    'gnumeric' => 'Gnumeric',
                    'htm' => 'Html',
                    'html' => 'Html',
                    'csv' => 'Csv',
                    'tsv' => 'Csv',
                    'pdf' => 'Dompdf',
                ),
            'value_binder' =>
                array (
                    'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
                ),
            'cache' =>
                array (
                    'driver' => 'memory',
                    'batch' =>
                        array (
                            'memory_limit' => 60000,
                        ),
                    'illuminate' =>
                        array (
                            'store' => NULL,
                        ),
                ),
            'transactions' =>
                array (
                    'handler' => 'db',
                    'db' =>
                        array (
                            'connection' => NULL,
                        ),
                ),
            'temporary_files' =>
                array (
                    'local_path' => '/var/www/egemen/data/www/laravel/egemen.kz/storage/framework/cache/laravel-excel',
                    'remote_disk' => NULL,
                    'remote_prefix' => NULL,
                    'force_resync_remote' => NULL,
                ),
        ),
    'trustedproxy' =>
        array (
            'proxies' => NULL,
            'headers' => 30,
        ),
    'tinker' =>
        array (
            'commands' =>
                array (
                ),
            'dont_alias' =>
                array (
                    0 => 'App\\Nova',
                ),
        ),
);
