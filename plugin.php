<?php
/*
Plugin Name: Gutenberg challenge introduction
Plugin URI: http://onocom.net/
Description:  Gutenberg challenge introduction. 
Author: onocom
Author URI: http://onocom.net/
Version: 1.0.0

License:
 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html
  Copyright 2018 Takashi Ono

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
class gutenberg_challenge_introduction {
	
	static $instance = null;
	
	protected  $page_templates;
	
	
	function __construct(){
		self::$instance = $this;
		
		$this->page_templates = array(
									"template-introduction.php" => 'Gutenberg challenge introduction'
								);
		add_filter(
			'wp_insert_post_data', 
			array( $this, 'register_project_templates' ) 
		);

		/**
		 * ログインページにユーザ名とパスワードを表示する
		 */
		add_filter('login_message', array( $this, 'custom_login_message' ));


		// Add a filter to the template include to determine if the page has our 
		// template assigned and return it's path
		add_filter('template_include', array( $this, 'view_project_template'));
		
		add_filter('theme_page_templates', array( $this, 'add_new_template' ));
		
		register_activation_hook(__FILE__, array($this, 'activate'));
		register_deactivation_hook(__FILE__, array($this, 'deactivate'));
	}
	
	
	public function activate() {
		
	}

	public function deactivate() {
		
	}

	public static function get_instance() {
		
		if( self::$instance != null ) {
			return self::$instance;
		} else {
			return new self();
		}
	}

	public function custom_login_message() {
		$message = '<p class="message">' . $this->get_login_user_data() . '</p><br />';
		return $message;
	}

	public function get_plugin_template_part($slug, $name = null) {
		$slug;
		
		$templates = array();
		$name = (string) $name;
		if ( '' !== $name )
			$templates[] = "{$slug}-{$name}.php";
		
		$templates[] = "{$slug}.php";
		$located = '';
		foreach ( (array) $templates as $template_name ) {
			if ( !$template_name ) {
				continue;
			}
			if ( file_exists($this->get_plugin_path() . '/' . $template_name) ) {
				$located = $this->get_plugin_path() . '/' . $template_name;
				break;
			}
		}
		if($located) {
			require_once( $located );
		}
	}
	public function get_plugin_url() {
		return plugins_url("",__FILE__);
	}
	public function get_plugin_path() {
		return dirname(__FILE__);
	}
	
	/**
	 * ユーザ名取得
	 */
	public function get_username() {
		return "gutenberg";
	}
	
	/**
	 * パスワード取得
	 * 　生成されるパスワードは毎日変更される
	 */
	public function get_password() {
		// 日付とサイトURLでハッシュを生成して12文字程度で切る
		$today = date_i18n("Ymd");
		$site_url = get_site_url();
		$hash = hash('md5', $today . $site_url );
		$hash = str_rot13($hash);
		$hash = mb_convert_case($hash, MB_CASE_TITLE);
		$search  = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
		$replace = array( '@', '#', '+', ',', '$', '-', '_', '!', '%', '@', '#', '+', ',', '$', '-', '_', '!', '%', '@', '#', '+', ',', '$', '-', '_', '!' );

		$hash = str_replace($search,$replace,$hash);
		$password = mb_substr($hash,5,12);
		return $password;
	}

	/**
	 * ユーザー名とパスワードを表示
	 */
	public function get_login_user_data() {
		$username = $this->get_username();
		$password = $this->get_password();
		return 'username: ' . esc_html($username) . ' / password: ' . esc_html($password) . '';
	}
	
	/**
	 * ログイン画面へのリンクを生成
	 */
	public function get_edit_link() {
		if( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( get_site_url()."/wp-admin/post-new.php" );?>" class="btn btn-secondary btn-lg">Gutenberg 編集画面へ</a>
		<?php  else : ?>
			<h2 class="display-5">LOGIN</h2>
			<p><a href="<?php echo esc_url( get_site_url() . "/wp-login.php?redirect_to=" . get_site_url() . "/wp-admin/post-new.php" );?>" class="btn btn-secondary">ログイン画面</a></p>
			<p><?php $this->get_login_user_data();?></p>
		<?php
		endif; 
	}
	

	/**
	 * 固定ページ用のページテンプレートを追加
	 * http://www.wpexplorer.com/wordpress-page-templates-plugin/
	 */
	public function add_new_template( $page_templates ) {
		$page_templates = array_merge( $page_templates, $this->page_templates );
		return $page_templates;
	}

	public function register_project_templates( $atts ) {

		// Create the key used for the themes cache
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		// Retrieve the cache list. 
		// If it doesn't exist, or it's empty prepare an array
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		} 

		// New cache, therefore remove the old one
		wp_cache_delete( $cache_key , 'themes');

		// Now add our template to the list of templates by merging our templates
		// with the existing templates array from the cache.
		$templates = array_merge( $templates, $this->page_templates );

		// Add the modified cache to allow WordPress to pick it up for listing
		// available templates
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );

		return $atts;

	}

	public function view_project_template( $template ) {
		
		// Get global post
		global $post;

		// Return template if post is empty
		if ( ! $post ) {
			return $template;
		}

		// Return default template if we don't have a custom one defined
		if ( ! isset( $this->page_templates[get_post_meta( 
			$post->ID, '_wp_page_template', true 
		)] ) ) {
			return $template;
		} 

		$file = plugin_dir_path( __FILE__ ) . get_post_meta( $post->ID, '_wp_page_template', true );

		// Just to be safe, we check if the file exist first
		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		// Return template
		return $template;

	}
	
	
}
new gutenberg_challenge_introduction();
