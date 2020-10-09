<?php
	class Map{
		private $db;
		private $type;
		
		public function __construct() {
			$this->db = db("map");
		}
		
		/*
			设置要操作的数据类型
		*/
		public function type($type){
			$this->type = $type;
			return $this;
		}
		
		
		/*
			获取数值
		*/
		public function getValue($key,$default=false){
			$res = $this->db->where(["type"=>$this->type,"key"=>$key])->find();
			if($res){
				return $res["value"];
			}else{
				if($default){
					return $default;
				}else{
					return false;
				}
			}
		}
		
		public function getAll(){
			$res = $this->db->where(["type"=>$this->type])->select();
			if($res){
				foreach($res as $vo){
					$data[$vo["key"]] = $vo["value"];
				}
				return $data;
			}else{
				return false;
			}
		}
		/*
			添加数值
		*/
		public function add($key,$value){
			$res = $this->db->where(["type"=>$this->type,"key"=>$key])->find();
			if($res){
				return false;
			}else{
				if($this->db->insert(["type"=>$this->type,"key"=>$key,"value"=>$value]))
				{
					return true;
				}else{
					return false;
				};
			}
		}
		
		public function update($key,$value){
			$res = $this->db->where(["type"=>$this->type,"key"=>$key])->find();
			if($res){
				if($this->db->where(["type"=>$this->type,"key"=>$key])->update(["value"=>$value])){
					return true;
				}else{
					return false;
				};
			}else{
				if($this->db->insert(["type"=>$this->type,"key"=>$key,"value"=>$value]))
				{
					return true;
				}else{
					return false;
				};
			}
		}
		
	
		
		public function del($key){
			$this->db->where(["type"=>$this->type,"key"=>$key])->delete();
		}
		public function clear(){
			$this->db->where(["type"=>$this->type])->delete();
		}
	}
