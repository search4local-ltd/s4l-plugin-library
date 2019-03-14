<?php

/**
 * GitHub plugin updater class
 * @since 1.0
 */
class GitHubPluginUpdater {

	private $slug;
	private $pluginData;
	private $username;
	private $repo;
	private $pluginFile;
	private $githubAPIResult;
	private $accessToken;

	function __construct( $pluginFile, $gitHubUsername, $gitHubProjectName, $accessToken = '' ) {
		add_filter( "pre_set_site_transient_update_plugins", array( $this, "setTransitent" ) );
		add_filter( "plugins_api", array( $this, "setPluginInfo" ), 10, 3 );
		add_filter( "upgrader_post_install", array( $this, "postInstall" ), 10, 3 );

		$this->pluginFile = $pluginFile;
		$this->username = $gitHubUsername;
		$this->repo = $gitHubProjectName;
		$this->accessToken = $accessToken;

	}

	// Get info regarding plugin from WP
	private function initPluginData() {
		$this->slug = plugin_basename( $this->pluginFile );
		$this->pluginData = get_plugin_data( $this->pluginFile );
	}

	// Get info regarding plugin from GitHub
	private function getRepoReleaseInfo() {
		// Only do this once
		if( !empty( $this->gitHubAPIResult ) ) {
			return;
		}

		// Query GitHub API
		$url = 'https://api.github.com/repos/search4local-ltd/s4l-plugin-library/releases';

		// Access token for private repo
		if( !empty( $this->accessToken ) ) {
			$url = add_query_arg( array( "access_token" => $this->accessToken ), $url );
		}

		// Get the results
		$this->githubAPIResult = wp_remote_retrieve_body( wp_remote_get( $url ) );
		if( !empty( $this->githubAPIResult ) ) {
			$this->githubAPIResult = @json_decode( $this->githubAPIResult );
		}

		// Use only the latest release of plugin
		if( is_array( $this->githubAPIResult ) ) {
			$this->githubAPIResult = $this->githubAPIResult[0];
		}
	}

	// Push in plugin version info to get update notification
	public function setTransient( $transient ) {

		// if we have check the plugin data before, don't re-check
		if( empty( $transient->checked ) ) {
			return $transient;
		}

		// Get plugin & GitHub release info
		$this->initPluginData();
		$this->getRepoReleaseInfo();

		// Check the versions to see if we need to update
		$doUpdate = version_compare( $this->githubAPIResult->tag_name, $transient->checked[$this->slug] );

		// Update the transient to include our update plugin data
		if( $doUpdate ) {
			$package = $this->githubAPIResult->zipball_url;

			// Include access token for private repo
			if( !empty( $this->accessToken ) ) {
				$package = add_query_arg( array( "access_token" => $this->accessToken ), $package );
			}

			$obj = new stdClass();
			$obj->slug = $this->slug;
			$obj->new_version = $this->githubAPIResult->tag_name;
			$obj->url = $this->pluginData["PluginURI"];
			$obj->package = $package;
			$transient->response[$this->slug] = $obj;

		}

		return $transient;
	}

	// Push in plugin version info to display in details box
	public function setPluginInfo( $false, $action, $response ) {

		// Get plugin & GitHub release info
		$this->initPluginData();
		$this->getRepoReleaseInfo();

		// if nothing is found, do nothing (like James)
		if ( empty( $response->slug ) || $response->slug != $this->slug ) {
			return false;
	}

		// Add plugin information
		$response->last_updated = $this->githubAPIResult->published_at;
		$response->slug = $this->slug;
		$response->plugin_name = $this->pluginData['Name'];
		$response->version = $this->githubAPIResult->tag_name;
		$response->author = $this->pluginData['AuthorName'];
		$response->homepage = $this->pluginData["PluginURI"];

		// This is our release zip file
		$downloadLink = $this->githubAPIResult->zipball_url;

		// Include access token
		if( !empty( $this->accessToken ) ) {
			$downloadLink = add_query_arg( array( "access_token" => $this->accessToken ), $downloadLink );
		}
		$response->download_link = $downloadLink;

		// Parse github markdown
		require_once( plugin_dir_path(__FILE__) . 'Parsedown.php'  );

		// Create tabs in lightbox
		$response->sections = array(
			'description' => $this->pluginData['Description'],
			'changelog' => class_exists( "Parsedown" ) ? Parsedown::instance()->parse( $this->githubAPIResult->body ) : $this->githubAPIResult->body
		);

		// Get required version of WP
		$matches = null;
		preg_match( "/requires:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches );
		if( !empty( $matches ) ) {
			if( is_array( $matches ) ) {
				if( count( $matches ) > 1 )
					$response->requires = $matches[1];
			}
		}

		// Gets the tested version of WP if available
		$matches = null;
		preg_match( "/tested:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches );
		if ( ! empty( $matches ) ) {
			if ( is_array( $matches ) ) {
				if ( count( $matches ) > 1 ) {
						$response->tested = $matches[1];
				}
			}
		}

		return $response;
	}

	// Perform addition actions to install plugin
	public function postInstall( $true, $hook_extra, $result ) {

		// Get plugin info
		$this->initPluginData();

		// Remember if our plugin was already activated
		$wasActivated = is_plugin_active( $this->slug );

		// As we are hosted in github, plugin foler would have a dirname of reponame-tagname change it to the orignal name.
		global $wp_filesystem;
		$pluginFolder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname( $this->slug );
		$wp_filesystem->move( $result['destination'], $pluginFolder );
		$reslut['destination'] = $pluginFolder;

		// Re-activate plugin if needed
		if ( $wasActivated )
			$activate = activate_plugin( $this->slug );

		return $result;
	}

}