<?php
/**
 * The manifest of files that are local to specific environment.
 * This file returns a list of environments that the application
 * may be installed under. The returned data must be in the following
 * format:
 *
 * ```php
 * return [
 *     'environment name' => [
 *         'path' => 'directory storing the local files',
 *         'skipFiles'  => [
 *             // list of files that should only copied once and skipped if they already exist
 *         ],
 *         'setWritable' => [
 *             // list of directories that should be set writable
 *         ],
 *         'setExecutable' => [
 *             // list of files that should be set executable
 *         ],
 *         'setCookieValidationKey' => [
 *             // list of config files that need to be inserted with automatically generated cookie validation keys
 *         ],
 *         'createSymlink' => [
 *             // list of symlinks to be created. Keys are symlinks, and values are the targets.
 *         ],
 *     ],
 * ];
 * ```
 */
return [
    'Development' => [
        'path' => 'dev',
        'setWritable' => [
            'backend/runtime',
            'backend/web/assets',
<<<<<<< HEAD
            'frontend/runtime',
            'frontend/web/assets',
            'api/runtime',
            'api/web/assets',
=======
            'console/runtime',
            'frontend/runtime',
            'frontend/web/assets',
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
        ],
        'setExecutable' => [
            'yii',
            'yii_test',
        ],
        'setCookieValidationKey' => [
            'backend/config/main-local.php',
<<<<<<< HEAD
            'frontend/config/main-local.php',
            'api/config/main-local.php',
=======
            'common/config/codeception-local.php',
            'frontend/config/main-local.php',
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
        ],
    ],
    'Production' => [
        'path' => 'prod',
        'setWritable' => [
            'backend/runtime',
            'backend/web/assets',
<<<<<<< HEAD
            'frontend/runtime',
            'frontend/web/assets',
            'api/runtime',
            'api/web/assets',
=======
            'console/runtime',
            'frontend/runtime',
            'frontend/web/assets',
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
        ],
        'setExecutable' => [
            'yii',
        ],
        'setCookieValidationKey' => [
            'backend/config/main-local.php',
            'frontend/config/main-local.php',
<<<<<<< HEAD
            'api/config/main-local.php',
=======
>>>>>>> 4a2cdc722d881805c25cac6c1c33b11bab592d89
        ],
    ],
];
