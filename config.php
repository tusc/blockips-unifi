<?php
/**
 * Copyright (c) 2017, Art of WiFi
 *
 * This file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.md
 *
 */

/**
 * Controller configuration
 * ===============================
 * Copy this file to your working directory, rename it to config.php and update the section below with your UniFi
 * controller details and credentials
 */
$controlleruser     = 'mylogin@gmail.com'; // the user name for access to the UniFi Controller
$controllerpassword = 'mypassword'; // the password for access to the UniFi Controller
$controllerurl      = 'https://192.168.1.1'; // full url to the UniFi Controller, eg. 'https://22.22.11.11:8443', for UniFi OS-based

                          // controllers a port suffix isn't required, no trailing slashes should be added
$controllerversion  = '6.0.3'; // the version of the Controller software, e.g. '4.6.6' (must be at least 4.0.0)



/** the site to use */
$site_id = 'default';

/** Set this value to the firewall group name**/
$group_name = 'Block_Group';

/** Set this value to the firewall rule name in WAN OUT**/
$rule_name = 'Scheduled Block Group';


/**
 * set to true (without quotes) to enable debug output to the browser and the PHP error log
 */
$debug = false;

