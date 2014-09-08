<?php

/**
 * Global and Local Hooks for the Domain_Management plugin
 * Global Hooks are defined with the prefix(name of the plugin)
 * Local Hooks are defined with normal function name 
 * 
 * All the Global Hooks are called during the page load
 * and Local Hooks are called according to conditions
 * 
 * Here, we request to the Domain_Management url using REST 
 * to get the contents and will display with this plugin.
 * 
 * @author shubham meena mentored by Matthew Lagoe 
 */


// Global variable to store the data which is
// returned to the templates
$domain_management_return_set = array();

// Local variable to store data during
// functionalities of the hooks
$var_set = array();

/**
 * Display hook for Domain_Management plugin
 */
function domain_management_hook_display()
 {
    global $domain_management_return_set;
     // to display plugin name in menu bar
    $domain_management_return_set['admin_menu_display'] = 'Domain Management';
    $domain_management_return_set['icon'] = 'icon-edit';
     } 

/**
 * Global Hook to interact with the REST api
 * Pass the variables in the REST object to 
 * make request 
 * 
 * variables REST object expects
 * url --> on which request is to be made
 * appkey --> app key for authentication
 * host --> host from which request have been sent
 * 
 * @return $domain_management_return_set global array returns the template data
 */
function domain_management_hook_call_rest()
 {

    global $domain_management_return_set;
    global $WEBPATH;
    
    $domain_management_return_set['path'] = $WEBPATH;

    } 

/**
 * Global Hook to return global variables which contains
 * the content to use in the smarty templates extracted from 
 * the database
 * 
 * @return $domain_management_return_set global array returns the template data
 */
function domain_management_hook_get_db()
 {
    global $domain_management_return_set;
    
        $db = new DBLayer( 'shard' );
        
        //get all domains
        $statement = $db->executeWithoutParams("SELECT * FROM domain");
        $rows = $statement->fetchAll();   
        $domain_management_return_set['domains'] = $rows;

        if (isset($_GET['edit_domain'])){
        //get permissions
        $statement = $db->executeWithoutParams("SELECT * FROM `permission` WHERE `DomainId` = '".$rows[$_GET['edit_domain']-1]['domain_name']."'");
        $rows = $statement->fetchAll();   
        $domain_management_return_set['permissions'] = $rows;
        
        //get all users
        $pagination = new Pagination(WebUsers::getAllUsersQuery(),"web",10,"WebUsers");
        $domain_management_return_set['userlist'] = Gui_Elements::make_table($pagination->getElements() , Array("getUId","getUsername","getEmail"), Array("id","username","email"));
        
        }
        
        return $rows;
    } 

/**
 * Global Hook to return global variables which contains
 * the content to use in the smarty templates
 * 
 * @return $domain_management_return_set global array returns the template data
 */
function domain_management_hook_return_global()
 {
    global $domain_management_return_set;
     return $domain_management_return_set;
     }