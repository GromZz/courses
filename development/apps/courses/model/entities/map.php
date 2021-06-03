<?php

namespace Model\Entities;

class Map
{

	use \Library\Shared;
	use \Library\Entity;

	public static function search(?Int $discipline = 0, ?String $description = '', Int $limit = 0):self|array|null {
		$result = [];
		foreach (['discipline', 'description'] as $var)
			if ($$var)
				$filters[$var] = $$var;
		$db = self::getDB();
		$maps = $db -> select(['RoadMap' => []]);
		if(!empty($filters))
			$maps->where(['RoadMap' => $filters]);
		foreach ($maps->many($limit) as $map) {
				$class = __CLASS__;
				$result[] = new $class($map['discipline'], $map['description']);
		}
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;	
	}

	public static function loadMap(int $limit = 0): ?array {
		$result = [];
		$db = self::getDB();
		foreach ($db -> select([
			'RoadMap' => []
		  ])->where([
			'RoadMap' => []
		  ])->many($limit) as $map) {
					$class = __CLASS__;
					$result[] = new $class($map['discipline'], $map['description']);
		  }
		  return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;
	}


	public function edit(array $data){
		$db = $this->db;
		$db -> update('RoadMap', $data)
			-> where(['RoadMap'=> ['discipline' => $this->discipline]])
			-> run();
	  }

	public function __construct(public ?int $discipline = 0, public ?String $description = '') {
		$this->db = $this->getDB();
		//printme($this);
	}
}