<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
define('SHOW_DEBUG_BACKTRACE', TRUE);

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
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


// define('CI_UPLOAD_PATH', 'uploads/');
define('UPLOADPATH', 'apis/public/files/');
define('BUILDZONE', 'user/buildzone');
define('FILE_UPLOAD', 'file/upload');

define('USER_LIST', 'user/list');
define('USER_UPDATE', 'user/update');
define('USER_DELETE', 'user/delete');
define('USER_STATUS_UPDATE', 'user/status/update');
define('SIGNUP', 'user/signup');
define('LOGIN', 'user/login');
define('CHANGE_PASSWORD', 'user/change_password');
define('LOGOUT', 'user/logout');
//define('QRCODE_SEND', 'user/qrcode/send');

define('PRODUCT_LIST', 'product/list');
define('PRODUCT_CREATE', 'product/create');
define('PRODUCT_DELETE', 'product/delete');
define('PRODUCT_STATUS_UPDATE', 'product/status/update');
define('PRODUCT_FRONTEND_LIST', 'product/frontend/list');

// define('BANK_LIST', 'bank/list');
// define('BANK_CREATE', 'bank/create');
// define('BANK_DELETE', 'bank/delete');

// define('COUPON_LIST', 'coupon/list');
// define('COUPON_CREATE', 'coupon/create');
// define('COUPON_DELETE', 'coupon/delete');

// define('TRANSECTION_LIST', 'user/transection');

// define('DEPOSIT_LIST', 'deposit/list');
// define('DEPOSIT_CREATE', 'deposit/create');
// define('DEPOSIT_UPDATE', 'deposit/update');

// define('PAYMENT_LIST', 'payment_transfer/list');
// define('PAYMENT_CREATE', 'payment_transfer/create');
// define('PAYMENT_UPDATE', 'payment_transfer/update');

// define('WALLET_TRANSFER_LIST', 'wallet_transfer/list');
// define('WALLET_TRANSFER_CREATE', 'wallet_transfer/create');

// define('WALLET', 'user/wallet');

// define('COMMISSION_LIST', 'commission/list');
// define('COMMISSION_TO_USER_LIST', 'commission/to_user/list');
// define('COMMISSION_TO_USER_CREATE', 'commission/to_user/create');

define('FORGET_PASSWORD', 'user/forget_password');
define('NEW_PASSWORD', 'user/forget_password/new_password');

// define('SALES_TEAM_CREATE', 'salesteam/create');
// define('SALES_TEAM_LIST', 'salesteam/list');
// define('SALES_TEAM_UPDATE', 'salesteam/update');
// define('SALES_TEAM_DELETE', 'salesteam/delete');
// define('SALES_TEAM_REPORT', 'salesteam/report');

define('SUPERADMIN_LOGIN', 'superadmin/login');
define('SUPERADMIN_CHANGE_PASSWORD', 'superadmin/change_password');
define('SUPERADMIN_LOGOUT', 'superadmin/logout');
define('SUPERADMIN_LIST', 'superadmin/list');
define('SUPERADMIN_UPDATE', 'superadmin/update');
define('SUPERADMIN_REPORT', 'superadmin/reports');
