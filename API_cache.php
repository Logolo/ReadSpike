<?php
/*
* Caches API calls to a local file which is updated on a 
* given time interval.
*/
class API_cache {
  
  private 
      $_update_interval // how often to update
    , $_cache_file // file to save results to
    , $_api_call; // API call (URL with params)

  public function __construct ($tw, $int=10, $cf='cache/api_cache.json') {
    $this->_api_call = $tw;
    $this->_update_interval = $int * 60; // minutes to seconds
    $this->_cache_file = $cf;
  }

  /*
   * Updates cache if last modified is greater than
   * update interval and returns cache contents
   */
  public function get_api_cache () {
    if (!file_exists($this->_cache_file) || 
        time() - filemtime($this->_cache_file) > $this->_update_interval) {
      $this->_update_cache();
    }
    return file_get_contents($this->_cache_file);
  }

  /*
   * Http expires date
   */
  public function get_expires_datetime () {
    if (file_exists($this->_cache_file)) {
      return date (
        'D, d M Y H:i:s \G\M\T', 
        filemtime($this->_cache_file) + ($this->_update_interval)
      );
    }
  }

  /*
   * Makes the api call and updates the cache 
   */
  private function _update_cache () {
    // update from api if past interval time
    $fp = fopen($this->_cache_file, 'w+'); // open or create cache
    if ($fp) {
      if (flock($fp, LOCK_EX)) {
        $tweets = file_get_contents ($this->_api_call);
        fwrite($fp, $tweets);
        flock($fp, LOCK_UN);
      }
      fclose($fp);
    }
  }
  
}