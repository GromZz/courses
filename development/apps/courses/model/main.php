<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE->model
 * @package Model\Main
 */
namespace Model;

use \Model\Entities\Course;
use \Model\Entities\Software;
use \Model\Entities\Competency;
use \Model\Entities\Policy;
use \Model\Entities\Result;
use \Model\Entities\Map;
use \Model\Entities\Work;

class Main
{
	use \Library\Shared;


	public function uniwebhook(String $type = '', String $value = '', Int $code = 0):?array {
		$result = null;
		switch ($type) {
			case 'message':
				if ($value == 'вихід') {
					$result = ['type' => 'context', 'set' => null];
				} else
				$result = [
					'to' => $GLOBALS['uni.user'],
					'type' => 'message',
					'value' => "Сервіс `Texнічні дані` отримав повідомлення $value"
				];
				break;
				case 'click':
					$result = [
						'to' => $GLOBALS['uni.user'],
						'type' => 'message',
						'value' => "Сервіс `Texнічні дані`. Натиснуто кнопку $code",
						'keyboard' => [
							'inline' => false,
							'buttons' => [
								[['id' => 9, 'title' => 'Надати номер', 'request' => 'contact']]
							]
						]
					];
					break;
				case 'contact':
					$result = [
						'to' => $GLOBALS['uni.user'],
						'type' => 'message',
						'value' => "Сервіс `Texнічні дані`. Отримано номер $value"
					];
					break;
		}

		return $result;
	}

	public function formsubmitAmbassador(String $firstname, String $secondname, String $phone, String $position = ''):?array {
		$result = null;
		$chat = 891022220;
		//$this->TG->alert("Нова заявка в *Цифрові Амбасадори*:\n$firstname $secondname, $position\n*Зв'язок*: $phone");
		$result = [];
		return $result;
	}

	public function __construct() {
		$this->db = new \Library\MySQL('core',
			\Library\MySQL::connect(
				$this->getVar('DB_HOST', 'e'),
				$this->getVar('DB_USER', 'e'),
				$this->getVar('DB_PASS', 'e')
			) );
		$this->setDB($this->db);
		//$this -> TG = new Services\Telegram(key: $this->getVar('TGKey', 'e'), emergency: 280751679);
	}

	//api методы для Courses

	public static function courseadd(?String $title = '', ?String $teacher = '', ?String $goal = '', ?String $control = '', ?String $department = '', ?String $retake = '', ?float $ects = 0, ?int $semester = 0, ?int $hours = 0, ?String $competency = '', ?String $policy = '', ?String $res = '', ?String $map = ''): array {
		$course = new \Model\Entities\Course(title: $title, teacher: $teacher, goal: $goal, control: $control, department: $department, retake: $retake, ects: $ects, semester:$semester, hours:$hours, competency:$competency, policy:$policy, res:$res, map:$map);
		$course->save();
		return [true];
	}

	public function coursedelete(?String $title = '') {
		$courses = [];
		$courses = Course::search(title: $title);
		foreach($courses as $course){
			$course->delete();
		}
		return [true];
    }

	public function courseedit(Int $id, String $data):?array {
		$result = [];
		$data = json_decode($data, true);
		$course = new Course(id: $id);
		$result['courses'] = $course->edit($data);
		return $result;
    }

	public function courseget(?String $title = '', ?String $teacher = '', ?String $control = '', ?int $semester = 0) {
		$courses = [];
		if($title){
			$courses = Course::search(title: $title);
		}
		elseif ($teacher) {
			$courses = Course::search(teacher: $teacher);
		}	
		elseif ($control) {
			$courses = Course::search(control: $control);
		}
		else{
			$courses = Course::search(semester: $semester);
		}
		return $courses;
	}

	//api методы для Software

	public static function softwareadd(?int $discipline = 0, ?String $title = '', ?String $system = ''): array {
		$software = new \Model\Entities\Software(discipline:$discipline, title: $title, system: $system);
		$software->save();
		return [true];
	}

	public function softwaredelete(?String $title = '') {
		$softwares = [];
		$softwares = Software::search(title: $title);
		foreach($softwares as $software){
			$software->delete();
		}
		return [true];
    }

	public function softwareedit(Int $id, String $data):?array {
		$result = [];
		$data = json_decode($data, true);
		$software = new Software(id: $id);
		$result['softwares'] = $software->edit($data);
		return $result;
    }

	public function softwareget(?String $title = '', ?String $system = '') {
		$softwares = [];	
		$softwares = ($title)
			? \Model\Entities\Software::search(title: $title)
			: \Model\Entities\Software::search(system: $system);
		return $softwares;
	}

	//api методы для Competency

	public function competencyedit(Int $discipline, String $data):?array {
		$result = [];
		$data = json_decode($data, true);
		$competency = new Competency(discipline: $discipline);
		$result['competencies'] = $competency->edit($data);
		return $result;
    }

	//api методы для Education_Policy

	public function policyedit(Int $discipline, String $data):?array {
		$result = [];
		$data = json_decode($data, true);
		$policy = new Policy(discipline: $discipline);
		$result['policies'] = $policy->edit($data);
		return $result;
    }

	//api методы для Results
	public function resultedit(Int $discipline, String $data):?array {
		$res = [];
		$data = json_decode($data, true);
		$result = new Result(discipline: $discipline);
		$res['results'] = $result->edit($data);
		return $res;
    }

	//api методы для RoadMap


	public function mapedit(Int $discipline, String $data):?array {
		$result = [];
		$data = json_decode($data, true);
		$map = new Map(discipline: $discipline);
		$result['maps'] = $map->edit($data);
		return $result;
    }

		//api методы для Works

		public static function workadd(?int $discipline = 0, ?String $type = '', ?String $title = '', ?String $goal = '', ?int $mark = 0, ?int $week = 0, ?String $criteria = ''): array {
			$work = new \Model\Entities\Work(discipline: $discipline, type: $type, title: $title, goal: $goal, mark: $mark, week: $week, criteria: $criteria);
			$work->save();
			return [true];
		}
	
		public function workdelete(?int $id = 0) {
			$works = [];
			$works = Work::search(id: $id);
			foreach($works as $work){
				$work->delete();
			}
			return [true];
		}
	
		public function workedit(Int $id, String $data):?array {
			$result = [];
			$data = json_decode($data, true);
			$work = new Work(id: $id);
			$result['works'] = $work->edit($data);
			return $result;
		}
	
		public function workget(?int $discipline = 0, ?String $type = '', ?int $week = 0) {
			$works = [];	
			if($discipline){
				$works = Work::search(discipline: $discipline);
			}
			elseif ($type) {
				$works = Work::search(type: $type);
			}
			else {
				$works = Work::search(week: $week);
			}
			return $works;
		}
}