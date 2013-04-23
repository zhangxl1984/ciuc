<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed_m extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_total_num() {
		$data = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."feeds");
		return $data;
	}

	function get_list($page, $ppp, $totalnum) {		
		$start = $this->base->page_get_start($page, $ppp, $totalnum);
		$data = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."feeds LIMIT $start, $ppp");

		foreach((array)$data as $k=> $v) {
			$searchs = $replaces = array();
			$title_data = $_ENV['misc']->string2array($v['title_data']);
			foreach(array_keys($title_data) as $key) {
				$searchs[] = '{'.$key.'}';
				$replaces[] = $title_data[$key];
			}
			$searchs[] = '{actor}';
			$replaces[] = $v['username'];
			$searchs[] = '{app}';
			$replaces[] = $this->base->apps[$v['appid']]['name'];
			$data[$k]['title_template'] = str_replace($searchs, $replaces, $data[$k]['title_template']);
			$data[$k]['dateline'] = $v['dateline'] ? $this->base->date($data[$k]['dateline']) : '';
		}
		return $data;
	}

}