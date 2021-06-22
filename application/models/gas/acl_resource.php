<?php

namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Acl_resource extends ORM {
	
	public $table = 'sip_acl_resource';
	
	public $primary_key = 'id';
	
	function _init() {
		
		self::$fields = array(
			'id' => ORM::field('auto'),
			'parent_id' => ORM::field('int'),
			'code' => ORM::field('string', array('required')),
			'label' => ORM::field('string', array('required')),
			'menu_type' => ORM::field('string', array('required')),
			'url' => ORM::field('varchar[255]'),
			'icon' => ORM::field('varchar[50]'),
		);
	}
    
    static function register($r) {
        //var_dump($r);
        $o = (object) $r;
        self::create_resource(
            $o->parent,
            $o->code,
            $o->label,
            $o->url,
            $o->icon,
            $o->menu_type,
            $o->enabled_groups
        );
    }
    
    static function create_resource($parent_code, $code, $label, $path_url, $icon = 'fa-navicon', $menu_type = 'sidebar', $enabled_groups = null) {
        
        $parent = self::result()->limit(1)->find_by_code($parent_code)->to_array();
        
        $parent = $parent ? $parent[0] : null;
        
        $CI =& get_instance();
        
        $pos = $CI->db->from('sip_acl_resource')->select_max('position')->get()->result_array();
        $pos = $pos ? $pos[0] : 0;
                
        $data = array(
            'parent_id' => $parent['id'],
            'code'      => $code,
            'label'     => $label,
            'url'       => $path_url,
            'icon'      => $icon,
            'position'  => $pos['position'] + 1,
            'menu_type' => $menu_type
        );
        
        //var_dump($data);
        
        $new_acl_resource = self::make($data);
        $new_acl_resource->save();
        
        if ( $new_acl_resource->save(TRUE)) {
            echo 'The raw errors were : ';
            print_r($new_acl_resource->errors);
        } else {
            echo "ACL Resource: [$label] successfully created. (ID: ".self::last_created()->id.')'. PHP_EOL;
        }
        
        Acl_restricted_resource::restrict_resource($code, $enabled_groups);
        echo "\n";
        
    }
}