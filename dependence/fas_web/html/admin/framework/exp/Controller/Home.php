<?php
	class Home extends C{
		public function index(){
			$this->set("data","Hell World！");
			$this->load('Home/index');
		}
	}
