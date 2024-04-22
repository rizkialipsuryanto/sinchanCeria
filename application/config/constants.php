<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code




// CUSTOM VARIABLE
// defined('IMAGE_BASE_URL')       or define('IMAGE_BASE_URL', '/var/www/html/simrs2020/assets/img/');

// defined('IMAGE_BASE_URL')       or define('IMAGE_BASE_URLL', 'assets/img/');
// defined('BASE_DATAID')          or define('BASE_DATAID', '1457');
// defined('BASE_SECRET')          or define('BASE_SECRET', '5uR5F9F782');
// defined('BASE_PPK')          or define('BASE_PPK', '1111R010');
// defined('BASE_URL_PRODUCTION')  or define('BASE_URL_PRODUCTION', 'https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/');

//dev bridging
// defined('IMAGE_BASE_URL')       or define('IMAGE_BASE_URLL', 'assets/img/');
// defined('BASE_DATAID')          or define('BASE_DATAID', '7910');
// defined('BASE_SECRET')          or define('BASE_SECRET', '8dY0BD285F');
// defined('BASE_PPK')          or define('BASE_PPK', '1111R010');
// defined('BASE_URL_PRODUCTION')  or define('BASE_URL_PRODUCTION', 'https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev/');

//production
defined('IMAGE_BASE_URL')       or define('IMAGE_BASE_URLL', 'assets/img/');
defined('BASE_DATAID')          or define('BASE_DATAID', '1457');
defined('BASE_SECRET')          or define('BASE_SECRET', '5uR5F9F782');
defined('BASE_PPK')          or define('BASE_PPK', '1111R010');
defined('BASE_URL_PRODUCTION')  or define('BASE_URL_PRODUCTION', 'https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/');

//develop antrian
// defined('IMAGE_BASE_URL_ANTREAN')       or define('IMAGE_BASE_URL_ANTREAN', 'assets/img/');
// defined('BASE_ANTREAN_DATAID')          or define('BASE_ANTREAN_DATAID', '7910');
// defined('BASE_ANTREAN_SECRET')          or define('BASE_ANTREAN_SECRET', '8dY0BD285F');
// defined('BASE_ANTREAN_PPK')          or define('BASE_ANTREAN_PPK', '1111R010');
// defined('BASE_ANTREAN_URL_PRODUCTION')  or define('BASE_ANTREAN_URL_PRODUCTION', 'https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/');

//production antrian
defined('IMAGE_BASE_URL_ANTREAN')       or define('IMAGE_BASE_URL_ANTREAN', 'assets/img/');
defined('BASE_ANTREAN_DATAID')          or define('BASE_ANTREAN_DATAID', '1457');
defined('BASE_ANTREAN_SECRET')          or define('BASE_ANTREAN_SECRET', '5uR5F9F782');
defined('BASE_ANTREAN_PPK')          or define('BASE_ANTREAN_PPK', '1111R010');
defined('BASE_ANTREAN_URL_PRODUCTION')  or define('BASE_ANTREAN_URL_PRODUCTION', 'https://apijkn.bpjs-kesehatan.go.id/antreanrs/');


// defined('BASE_SIRS_COVID_PRODUCTION')  or define('BASE_SIRS_COVID_PRODUCTION', 'http://sirs.yankes.kemkes.go.id/fo/index.php/');
defined('BASE_SIRS_COVID_PRODUCTION')  or define('BASE_SIRS_COVID_PRODUCTION', 'http://sirs.kemkes.go.id/fo/');
defined('BASE_RS_REFF')  or define('BASE_RS_REFF', '3302191');
defined('BASE_RS_REFF_PASS')  or define('BASE_RS_REFF_PASS', 'S!rs2020!!');


defined('BASE_SIRANP_PRODUCTION')  or define('BASE_SIRANP_PRODUCTION', 'http://sirs.yankes.kemkes.go.id/sirsservice/ranap');
defined('BASE_SIRANP_REFF')  or define('BASE_SIRANP_REFF', '3302191');
defined('BASE_SIRANP_REFF_PASS')  or define('BASE_SIRANP_REFF_PASS', '12345');
