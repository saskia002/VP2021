<?php
	
	class Test{ //klassi nimed võiksid alata suure tähega.
		//muutujad ehk properties
		private $secret_value = 7; //klassi sees saab ainult kasutada seda muutujat.
		public $non_secret_value = 9; //seda näeb ka väljaspool klassi.
		private $recived_secret;
		
		//fnc ehk method.
		function __construct($recived_value){  //construct siis see läheb see esimesena tööle.
			$this->recived_secret = $this->secret_value * $recived_value; //this minu enda klassi enda muutuja.
			echo "Saabunud väärtuse korrutis salajase arvuga on " .$this->recived_secret;
			$this->multiply();
		}
		
		function __destruct(){ //läheb viimasena tööle.
			echo "Klass lõpetas.";
			
		}
		
		private function multiply(){
			echo " Teine korrutis on ";
			
		}
		
		public function reveal(){
			echo "......";
		}
		
	}//klassi lõpp