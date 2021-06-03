<?php

namespace Model\Entities;

class Software
{

	use \Library\Shared;
	use \Library\Entity;

	public function save():self {
		$db = $this->db;
		$db -> insert([
			'Software' => [ 
				'discipline' => $this->discipline,
				'title' => $this->title, 
				'system' => $this->system]
		])->run(true)->storage['inserted'];
		if ($this->_changed)
			$db -> update('Software', $this->_changed )
				-> where(['Software'=> ['guid' => $this->guid]])
				-> run();
		return $this;
	}

	public static function search(?Int $id = 0, ?String $title = '', ?String $system = '', Int $limit = 0):self|array|null {
		$result = [];
		foreach (['id', 'title','system'] as $var)
			if ($$var)
				$filters[$var] = $$var;
		$db = self::getDB();
		$softwares = $db -> select(['Software' => []]);
		if(!empty($filters))
			$softwares->where(['Software' => $filters]);
		foreach ($softwares->many($limit) as $software) {
				$class = __CLASS__;
				$result[] = new $class($software['id'], $software['title'], $software['system']);
		}
		return $limit == 1 ? (isset($result[0]) ? $result[0] : null) : $result;	
	}

	public function delete() {
		$db = $this->db;
			$db -> delete('Software')
			-> where(['Software'=> ['id' => $this->id]])
			-> run();
	}

	public function edit(array $data){
		$db = $this->db;
		$db -> update('Software', $data)
			-> where(['Software'=> ['id' => $this->id]])
			-> run();
	  }

	public function __construct(public ?int $discipline = 0, public ?int $id = 0, public ?String $title = '', public ?String $system = '') {
		$this->db = $this->getDB();
		//printme($this);
	}
}