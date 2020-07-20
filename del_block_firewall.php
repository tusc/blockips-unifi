<?php
/**

remove ip addresses from firewall block group
 */


/**
 * using the composer autoloader
 */
require_once('/vendor/autoload.php');

/**
 * include the config file (place your credentials etc. there if not already present)
 * see the config.template.php file for an example
 */
require_once('/config.php');


if (empty($argv[1])) {
  echo "please pass ip addresses to delete from list\r\n";
  exit(1);
}

/**
 * initialize the UniFi API connection class and log in to the controller and do our thing
 */

$debug = false;
$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
$set_debug_mode   = $unifi_connection->set_debug($debug);
$loginresults     = $unifi_connection->login();

/** make sure firewall rule exists **/
$data             = $unifi_connection->list_firewallrules();
$rule_idx = array_search($rule_name,array_column($data,'name'));
if ($rule_idx == true) {
/**   echo json_encode($data[$rule_idx], JSON_PRETTY_PRINT);
**/
   $rule_id = $data[$rule_idx]->_id;
   echo "Id is ", $rule_id, "\r\n";
} else {
   echo "Firewall rule $rule_name not found! exiting....", "\r\n";
   exit(1);
}

/** list all firewall groups **/
$data             = $unifi_connection->list_firewallgroups();

/** search for group name as specified above **/
$grp_idx = array_search($group_name,array_column($data,'name'));

if ($grp_idx == true) {
   $group_id = $data[$grp_idx]->_id;
   echo "Id is ", $group_id,  "\r\n";;
} else {
   echo "Firewall Group $group_name not found! exiting....",  "\r\n";;
   exit(1);
}

echo "Before....\r\n";
echo json_encode($data[$grp_idx], JSON_PRETTY_PRINT);

/** loop through all ip addresses passed via command line **/

for ($i = 1; $i < $argc; $i++) {
  echo "Removing address $argv[$i]\r\n";

  $ip_addr=$argv[$i];

  $pos = array_search($ip_addr,$data[$grp_idx]->group_members);

  if ($pos == true) {
     echo "position is $pos\r\n";

     echo "IP found! Deleting....",  "\r\n";;
     unset($data[$grp_idx]->group_members[$pos]);
     $data[$grp_idx]->group_members = array_values($data[$grp_idx]->group_members);
    
  } else {
     echo "$ip_addr not found!\r\n",  "\r\n";;
     continue;
  }
}

echo "After....\r\n";
echo json_encode($data[$grp_idx], JSON_PRETTY_PRINT);

$data	= $unifi_connection->edit_firewallgroup($data[$grp_idx]->_id,$data[$grp_idx]->site_id,$data[$grp_idx]->name,$data[$grp_idx]->group_type,$data[$grp_idx]->group_members);

if (!$data) {
    $error = $unifi_connection->get_last_results_raw();
    echo json_encode($error, JSON_PRETTY_PRINT);
}
