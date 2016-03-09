<?php

// Pandora FMS - http://pandorafms.com
// ==================================================
// Copyright (c) 2005-2011 Artica Soluciones Tecnologicas
// Please see http://pandorafms.org for full contribution list

// This program is free software; you can redistribute it and/or
// modify it under the terms of the  GNU Lesser General Public License
// as published by the Free Software Foundation; version 2

// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.



/**
 * @package Include
 * @subpackage Maps
 */

abstract class Map {
	protected $status = STATUS_OK;
	
	protected $id = null;
	
	protected $type = null;
	protected $subtype = null;
	protected $id_group = null;
	protected $generation_method = null;
	
	protected $width = null;
	protected $height = null;
	
	protected $nodes = array();
	protected $edges = array();
	
	protected $requires_js = null;
	
	protected $is_buggy_firefox = false;
	
	public static function getName($id = null) {
		if (empty($id)) {
			return null;
		}
		else {
			return db_get_value('name', 'tmap', 'id', $id);
		}
	}
	
	public function __construct($id) {
		$this->id = $id;
		
		$this->requires_js = array();
		$this->requires_js[] = "include/javascript/d3.3.5.14.js";
		$this->requires_js[] = "include/javascript/map/MapController.js";
		$this->requires_js[] = "include/javascript/jquery.tooltipster.js";
		$this->requires_js[] = "include/javascript/jquery.svg.js";
		$this->requires_js[] = "include/javascript/jquery.svgdom.js";
		$this->requires_js[] = "include/javascript/d3-context-menu.js";
		
		if (!$this->loadDB()) {
			$this->status = STATUS_ERROR;
		}
	}
	
	protected function processDBValues($dbValues) {
		$this->type = (int)$dbValues['type'];
		$this->subtype = (int)$dbValues['subtype'];
		
		$this->id_group = (int)$dbValues['id_group'];
		$this->generation_method = (int)$dbValues['generation_method'];
		
		$this->width = (int)$dbValues['width'];
		$this->height = (int)$dbValues['height'];
	}
	
	private function loadDB() {
		$row = db_get_row_filter('tmap', array('id' => $this->id));
		
		if (empty($row))
			return false;
		
		switch (get_class($this)) {
			case 'Networkmap':
				Networkmap::processDBValues($row);
				break;
			case 'NetworkmapEnterprise':
				NetworkmapEnterprise::processDBValues($row);
				break;
			default:
				$this->processDBValues($row);
				break;
		}
	}
	
	abstract function printJSInit();
	
	public function writeJSGraph() {
		
//~ $this->nodes = json_decode('[
//~ {
	//~ "graph_id": "165",
	//~ "id": "17",
	//~ "type": 0,
	//~ "x": 1033.4,
	//~ "y": 806.38
//~ },
//~ {
	//~ "graph_id": "166",
	//~ "id": "198",
	//~ "type": 1,
	//~ "x": 1119.5,
	//~ "y": 847.85
//~ },
//~ {
	//~ "graph_id": 208,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": "169",
	//~ "id": "207",
	//~ "type": 1,
	//~ "x": 947.33,
	//~ "y": 764.91
//~ },
//~ {
	//~ "graph_id": 209,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": "179",
	//~ "id": "27",
	//~ "type": 0,
	//~ "x": 159.23,
	//~ "y": 1005.9
//~ },
//~ {
	//~ "graph_id": "180",
	//~ "id": "223",
	//~ "type": 1,
	//~ "x": 218.82,
	//~ "y": 931.19
//~ },
//~ {
	//~ "graph_id": "183",
	//~ "id": "89",
	//~ "type": 0,
	//~ "x": 516.77,
	//~ "y": 557.57
//~ },
//~ {
	//~ "graph_id": "184",
	//~ "id": "418",
	//~ "type": 1,
	//~ "x": 430.66,
	//~ "y": 599.03
//~ },
//~ {
	//~ "graph_id": "196",
	//~ "id": "412",
	//~ "type": 1,
	//~ "x": 602.88,
	//~ "y": 516.1
//~ },
//~ {
	//~ "graph_id": 212,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": 213,
	//~ "type": 2
//~ },
//~ 
//~ 
//~ 
//~ 
//~ 
//~ 
//~ {
	//~ "graph_id": 214,
	//~ "id": 666,
	//~ "type": 0,
	//~ "x": 300,
	//~ "y": 300
//~ },
//~ {
	//~ "graph_id": 215,
	//~ "id": 999,
	//~ "type": 0,
	//~ "x": 300,
	//~ "y": 100
//~ },
//~ {
	//~ "graph_id": 216,
	//~ "id": 999,
	//~ "type": 0,
	//~ "x": 300,
	//~ "y": 500
//~ },
//~ {
	//~ "graph_id": 217,
	//~ "id": 666,
	//~ "type": 0,
	//~ "x": 100,
	//~ "y": 300
//~ },
//~ {
	//~ "graph_id": 218,
	//~ "id": 666,
	//~ "type": 0,
	//~ "x": 500,
	//~ "y": 300
//~ },
//~ {
	//~ "graph_id": 219,
	//~ "id": 666,
	//~ "type": 0,
	//~ "x": 500,
	//~ "y": 100
//~ },
//~ {
	//~ "graph_id": 220,
	//~ "id": 666,
	//~ "type": 0,
	//~ "x": 500,
	//~ "y": 500
//~ },
//~ {
	//~ "graph_id": 221,
	//~ "id": 666,
	//~ "type": 0,
	//~ "x": 100,
	//~ "y": 100
//~ },
//~ {
	//~ "graph_id": 222,
	//~ "id": 666,
	//~ "type": 0,
	//~ "x": 100,
	//~ "y": 500
//~ },
//~ {
	//~ "graph_id": 400,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": 401,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": 402,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": 403,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": 404,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": 405,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": 406,
	//~ "type": 2
//~ },
//~ {
	//~ "graph_id": 407,
	//~ "type": 2
//~ }
//~ ]', true);
//~ 
//~ $this->edges = json_decode(
//~ '[
//~ {"to":"215","from":"214","graph_id":400},
//~ {"to":"216","from":"214","graph_id":401},
//~ {"to":"217","from":"214","graph_id":402},
//~ {"to":"218","from":"214","graph_id":403}
//~ ]', true);
//~ 
//~ $this->edges = json_decode(
//~ '[
//~ {"to":"219","from":"214","graph_id":404},
//~ {"to":"220","from":"214","graph_id":405},
//~ {"to":"221","from":"214","graph_id":406},
//~ {"to":"222","from":"214","graph_id":407}
//~ ]', true);


//~ $this->edges = json_decode(
//~ '[
//~ {"to":"215","from":"214","graph_id":400}
//~ ]', true);

//~ $this->edges = json_decode(
//~ '[
//~ {"to":"215","from":"214","graph_id":400},
//~ {"to":"216","from":"214","graph_id":401},
//~ {"to":"217","from":"214","graph_id":402},
//~ {"to":"218","from":"214","graph_id":403},
//~ {"to":"219","from":"214","graph_id":404},
//~ {"to":"220","from":"214","graph_id":405},
//~ {"to":"221","from":"214","graph_id":406},
//~ {"to":"222","from":"214","graph_id":407}
//~ ]', true);

//~ $this->edges = json_decode('[{"to":"165","from":"166","graph_id":208}]', true);
		
		
		?>
		<script type="text/javascript">
			var controller_map = null;
			<?php
			echo "var nodes = " . json_encode($this->nodes) . ";";
			echo "var edges = " . json_encode($this->edges) . ";";
			?>
			var temp = [];
			for (var i in nodes) { temp[parseInt(i)] = nodes[i];}
			nodes = temp;
			
			temp = [];
			for (var i in edges) { temp[parseInt(i)] = edges[i];}
			edges = temp;
		</script>
		<?php
	}
	
	private function check_browser() {
		global $config;
		
		$browser = get_browser_local(null, true, $config['homedir'] . '/include/browscap/php_browscap.ini');
		
		switch ($browser['browser']) {
			case 'Firefox':
				// Firefox BUG
				// https://bugzilla.mozilla.org/show_bug.cgi?id=1254159
				
				$this->is_buggy_firefox = true;
				break;
			case 'Microsoft':
				// Do install a GNU/Linux.
				break;
			default:
				// The world is a wonderful place.
				break;
		}
	}
	
	public function show() {
		// Tooltip css
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"include/styles/tooltipster.css\"/>" . "\n";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"include/styles/tooltipster-punk.css\"/>" . "\n";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"include/styles/tooltipster-shadow.css\"/>" . "\n";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"include/styles/tooltipster-noir.css\"/>" . "\n";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"include/styles/tooltipster-light.css\"/>" . "\n";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"include/styles/d3-context-menu.css\"/>" . "\n";
		//Tooltips spinner
		echo "<div id='spinner_tooltip' style='display:none;'>";
			html_print_image('images/spinner.gif');
		echo "</div>";
		foreach ($this->requires_js as $js) {
			echo "<script type='text/javascript' src='$js'></script>" . "\n";
		}
		
		$this->check_browser();
		
		$this->writeJSConstants();
		$this->writeJSGraph();
		
		?>
		<div id="map" data-id="<?php echo $this->id;?>" style="border: 1px red solid;">
			<div class="zoom_box" style="position: absolute;">
				<div class="zoom_controller">
					<input class="vertical_range" type="range" name="range" min="-666" max="666" step="1" value="666" />
				</div>
				<div class="zoom_in">+</div>
				<div class="zoom_out">-</div>
				<div class="home_zoom">H</div>
			</div>
			<?php
			if ($this->width == 0) {
				$width = "100%";
			}
			else {
				$width = $this->width . "px";
			}
			if ($this->height == 0) {
				$height = "500px";
			}
			else {
				$height = $this->height . "px";
			}
			
			
			?>
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" pointer-events="all" width="<?php echo $width;?>" height="<?php echo $height;?>">
			<?php
			$this->embedded_symbols_for_firefox();
			?>
			</svg>
		</div>
		
		<?php
		$this->printJSInit();
	}
	
	private function embedded_symbols_for_firefox() {
		global $config;
		
		if ($this->is_buggy_firefox) {
			echo "<defs>";
			// Firefox BUG
			// https://bugzilla.mozilla.org/show_bug.cgi?id=1254159
			
			$this->is_buggy_firefox = true;
			
			$dir_string = $config['homedir'] . '/images/maps/';
			if ($dir = opendir($dir_string)) {
				
				while (false !== ($file = readdir($dir))) {
					if (is_file($dir_string . $file)) {
						$xml = simplexml_load_file($dir_string . $file);
						$xml->registerXPathNamespace("x", "http://www.w3.org/2000/svg");
						
						$symbols = $xml->xpath("//x:symbol");
						//~ $symbols = $symbols->xpath("//symbol");
						echo $symbols[0]->asXML();
					}
				}
				closedir($dir);
			}
			echo "</defs>";
		}
	}
	
	public function writeJSConstants() {
		$contants = array();
		$contants["ITEM_TYPE_AGENT_NETWORKMAP"] = ITEM_TYPE_AGENT_NETWORKMAP;
		$contants["ITEM_TYPE_MODULE_NETWORKMAP"] = ITEM_TYPE_MODULE_NETWORKMAP;
		$contants["ITEM_TYPE_EDGE_NETWORKMAP"] = ITEM_TYPE_EDGE_NETWORKMAP;
		?>
		<script type="text/javascript">
			<?php
			foreach ($contants as $name => $value) {
				echo "var $name = $value \n";
			}
			echo "var is_buggy_firefox = " . ((int)$this->is_buggy_firefox) . ";\n";
			?>
		</script>
		<?php
	}
	
	public function getType() {
		return $this->type;
	}
}
?>
