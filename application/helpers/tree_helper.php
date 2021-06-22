<?php

if ( ! function_exists('build_tree'))
{
	function build_tree(array &$elements, $parentId = 0) {
		$branch = array();
		foreach ($elements as $key => $element) {
			if ($element['parent_id'] == $parentId) {
				$children = build_tree($elements, $element['id']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[$element['id']] = $element;
				unset($element);
			}
		}
		return $branch;
	}
	
}

if ( ! function_exists('recursive_array_search') ) {

	function recursive_array_search($needle, $haystack) {
		foreach($haystack as $key => $value) {
			$current_key = $key;
			if($needle === $value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
				return $current_key;
			}
		}
		return false;
	}
}