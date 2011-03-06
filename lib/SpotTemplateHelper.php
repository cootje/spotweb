<?php

# Utility class voor template functies, kan eventueel 
# door custom templates extended worden
class SpotTemplateHelper {	
	protected $_settings;
	protected $_prefs;
	
	function __construct($settings, $prefs) {
		$this->_settings = $settings;
		$this->_prefs = $prefs;
	} # ctor
	
	/*
	 * Creeert een URL naar de zoekmachine zoals gedefinieerd in de settings
	 */
	function makeSearchUrl($spot) {
		if (!isset($spot['filename'])) {
			$tmp = str_replace('$SPOTFNAME', $spot['title'], $this->_settings['search_url']);
		} else {
			$tmp = str_replace('$SPOTFNAME', $spot['filename'], $this->_settings['search_url']);
		} # else 

		return $tmp;
	} # makeSearchUrl

	/*
	 * Creeert een linkje naar de sabnzbd API zoals gedefinieerd in de 
	 * settings
	 */
	function makeSabnzbdUrl($spot) {
		# alleen draaien als we gedefinieerd zijn
		if ((!isset($this->_settings['sabnzbd'])) | (!isset($this->_settings['sabnzbd']['apikey'])) | (!isset($this->_settings['sabnzbd']['categories']))) {
			return '';
		} # if
		
		# fix de category
		$spot['category'] = (int) $spot['category'];
		
		# find een geschikte category
		$category = $this->_settings['sabnzbd']['categories'][$spot['category']]['default'];

		foreach($spot['subcatlist'] as $cat) {
			if (isset($this->_settings['sabnzbd']['categories'][$spot['category']][$cat])) {
				$category = $this->_settings['sabnzbd']['categories'][$spot['category']][$cat];
			} # if
		} # foreach
		
		# en creeer die sabnzbd url
		$tmp = $this->_settings['sabnzbd']['url'];
		$tmp = str_replace('$SABNZBDHOST', $this->_settings['sabnzbd']['host'], $tmp);
		$tmp = str_replace('$NZBURL', urlencode($this->_settings['sabnzbd']['spotweburl'] . '?page=getnzb&messageid='. $spot['messageid']), $tmp);
		$tmp = str_replace('$SPOTTITLE', urlencode($spot['title']), $tmp);
		$tmp = str_replace('$SANZBDCAT', $category, $tmp);
		$tmp = str_replace('$APIKEY', $this->_settings['sabnzbd']['apikey'], $tmp);

		return $tmp;
	} # sabnzbdurl

	# Function from http://www.php.net/manual/en/function.filesize.php#99333
	function format_size($size) {
		  $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		  if ($size == 0) { return('n/a'); } else {
		  return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
	} # format_size

} # class SpotTemplateHelper