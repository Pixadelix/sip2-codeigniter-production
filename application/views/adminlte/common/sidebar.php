<?php
$ci =& get_instance();
$controller = $ci->router->fetch_class();
$method     = $ci->router->fetch_method();

if ( ! function_exists( 'active_menu_children' ) ) {
	function active_menu_children($children) {
		//var_dump($children);
		foreach ($children as $c) {
			$active = ($c['url'] ? (strpos(current_url(), $c['url']) ? true : false) : false);
			if($active){
				return true;
			}
		}
		return false;
	}
}

if ( ! function_exists( 'render_tree_menu' ) ) {
	function render_tree_menu($items) {
		//var_dump($items); die;
		if( !$items )
			return;
		
		foreach($items as $i) {
			if(is_array($i)) { // && isset($i['children'])) {
				// check if sub menu active
				$active = (isset($i['children']) && active_menu_children($i['children'])) ? 'menu-open active' : '';
				$id = 'developments' == ENVIRONMENT ? '<small> ['.$i['id'].']</small>' : '';
?>
		<li class="treeview <?php echo $active; ?>">
			<a href="<?php echo $i['url']; ?>"><i class="fa <?php echo $i['icon']; ?>"></i> <span><?php echo $i['label'].$id; ?></span>
				<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
			</a>
<?php

			if(isset($i['children'])) {
				render_tree_sub_menu($i['children']);
			}
?>
		</li>
<?php
			}
		}
	}
}

if ( ! function_exists( 'render_tree_sub_menu' ) ) {
	function render_tree_sub_menu($items) { ?>
			<ul class="treeview-menu"><?php
		foreach($items as $i) {
			if(isset($i['children'])) {
				render_tree_menu(array($i));
			} else {
				$active = ($i['url'] ? (strpos(current_url(), $i['url']) ? 'active' : '') : '');
				if(is_array($i)) {
				$id = 'development' == ENVIRONMENT ? '<small class="pull-right"> ['.$i['id'].']</small>' : ''; ?>
				<li class="<?php echo $active; ?>"><a href='<?php echo $i['url'] ? base_url($i['url']) : '#'; ?>'><i class="fa <?php echo $i['icon']; ?>"></i><?php echo $i['label'].$id; ?></a></li>
	<?php		}
				if('workspace' == $i['code']) {
					get_active_workspace();
				}
				
				if('workspace-project-status' == $i['code']) {
					get_users_projects();
				}
			}
		}
?>
			</ul>
<?php
	}
}

$acl_resource = get_menu_resource();
//var_dump($acl_resource);

if ( ! function_exists( 'get_active_workspace' ) ) {
	function get_active_workspace() {
		$active_workspace = \Model\Workspace::result()->where_in('status' , WS_ACTIVE)->order_by('name, due_date')->get()->to_array();
		if($active_workspace) {
			echo '<li class="divider"></li>';
//			echo '<li><a href="#" class="treeview"><i class="fa fa-square-o"></i>Active<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a><ul class="treeview-menu">';
			for($i=0;$i<count($active_workspace);$i++){
				$ws = $active_workspace[$i];
?>
			<li><a href="/editorial/workspace/<?php echo $ws['id']; ?>"><?php echo ($i+1).'. '.$ws['name'].' <em class="note">('.substr($ws['edition'], 0, 10).')</em>'; ?></a></li>
<?php
			
			}
//			echo '</ul></li>';
			echo '<li class="divider"></li>';
		}
	}
}

if ( ! function_exists( 'get_users_projects' ) ) {
	function get_users_projects() {
		$ci =& get_instance();
		$user = Model\Users::find($ci->user_id);
		$projects = $user->projects();
		//echo '<li class="divider"></li>';
		$num = 0;
		foreach ( $projects as $project ) {
			//var_dump($project); die;
			$active_workspaces = $project->active_workspace();
			//var_dump($active_workspaces); die;
			if($active_workspaces) {
				echo '<li class="divider"></li>';
	//			echo '<li><a href="#" class="treeview"><i class="fa fa-square-o"></i>Active<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a><ul class="treeview-menu">';
				
				for($i=0;$i<count($active_workspaces);$i++){
					$ws = $active_workspaces[$i];
					/*
					if( $ws->status != WS_ACTIVE ) {
						continue;
					}
					*/
	?>
				<li><a href="/project_status/<?php echo $ws->id; ?>"><?php echo (++$num).'. '.$ws->name.' <em class="note">('.substr($ws->edition, 0, 10).')</em>'; ?></a></li>
	<?php
				
//				echo '<li class="divider"></li>';
				}
//				echo '</ul></li>';
				
			}
		}
	}
}

if ( ! function_exists( 'render_contents_menu' ) ) {
	function render_contents_menu() {
        if ( restricted( 'open-web-services', false ) ) {
            return;
        }
		$ci =& get_instance();
		$menu_posts = Model\Posts::where(
			array(
				'post_type' => 'post',
				'post_status' => 'published',
				'menu_order' => 1
			))
			->order_by('post_date', 'asc')
			->get();
		//var_dump($posts); die;
		$text_colors = array(
			'text-red',
			'text-yellow',
			'text-aqua',
//			'text-black',
			'text-light-blue',
			'text-blue',
			'text-green',
//			'text-navy',
			'text-teal',
			'text-olive',
			'text-lime',
			'text-orange',
			'text-fuchsia',
			'text-purple',
			'text-maroon',
			
			
		);
		if ( ! $menu_posts ) {
			return;
		}
		
		$menu_posts = is_array($menu_posts) ? $menu_posts : array($menu_posts);
		
		echo '<ul class="sidebar-menu"><li class="header">CONTENT</li>';
		
		foreach ( $menu_posts as $menu_post ) {
			$dt = explode('/', date('Y/m/d', strtotime($menu_post->post_date) ) );
			$perma_link = "/post/$dt[0]/$dt[1]/$dt[2]/$menu_post->id/$menu_post->post_name";
			
			echo '<li><a href="'.$perma_link.'"><i class="fa fa-circle-o '.array_shift($text_colors).'"></i> '.$menu_post->post_title.'</a></li>';
		}
		
		echo '</ul>';
	}
}

?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo get_userphoto(); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo get_userfullname(); ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
<?php /*
      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
*/ ?>
	  <?php if ( $acl_resource ) { ?>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
		<?php render_tree_menu($acl_resource); ?>
      </ul>
      <!-- /.sidebar-menu -->
	  <?php } ?>
		<?php render_contents_menu(); ?>
        <!--a href="https://play.google.com/store/apps/details?id=com.pixadelix.apps.app5679e24a5d65e" target="_blank">
            <img src="/assets/static/img/google-play-badge.png" class="img-responsive" style="position:absolute; bottom:0">
        </a-->
    </section>
    <!-- /.sidebar -->
  </aside>