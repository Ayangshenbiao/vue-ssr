<?php

namespace FernleafSystems\Wordpress\Services\Core\VOs;

use FernleafSystems\Utilities\Data\Adapter\StdClassAdapter;
use FernleafSystems\Wordpress\Services\Services;

/**
 * Class WpPluginVo
 * @package FernleafSystems\Wordpress\Services\Core\VOs
 * @property string Name
 * @property string Version
 * @property string Description
 * @property string PluginURI
 * @property string Author
 * @property string AuthorURI
 * @property string TextDomain
 * @property string DomainPath
 * @property bool   Network
 * @property string Title
 * @property string AuthorName
 * Extended Properties:
 * @property string id
 * @property string slug
 * @property string plugin
 * @property string new_version
 * @property string url
 * @property string package the update package URL
 * Custom Properties:
 * @property string file
 * @property string active
 */
class WpPluginVo {

	use StdClassAdapter;

	/**
	 * WpPluginVo constructor.
	 * @param string $sBaseFile
	 * @throws \Exception
	 */
	public function __construct( $sBaseFile ) {
		$oWpPlugins = Services::WpPlugins();
		$aPlug = $oWpPlugins->getPlugin( $sBaseFile );
		if ( empty( $aPlug ) ) {
			throw new \Exception( sprintf( 'Plugin file %s does not exist', $sBaseFile ) );
		}
		$aPlug = array_merge(
			$aPlug,
			Services::DataManipulation()->convertStdClassToArray( $oWpPlugins->getExtendedData( $sBaseFile ) )
		);
		$this->applyFromArray( $aPlug );
		$this->file = $sBaseFile;
		$this->active = $oWpPlugins->isActive( $sBaseFile );
	}

	/**
	 * @return bool
	 */
	public function hasUpdate() {
		return !empty( $this->new_version ) && version_compare( $this->new_version, $this->Version, '>' );
	}

	/**
	 * @return bool
	 */
	public function isWpOrg() {
		return isset( $this->id ) ? strpos( $this->id, 'w.org/' ) === 0 : false;
	}
}