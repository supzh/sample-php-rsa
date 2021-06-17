<?php

class sample_rsa
{			
	public  function encrypt($key, $m = 30)
	{
		$e = $key['publicKey'][1];
		$n = $key['publicKey'][0];
		$c = $this->Mode($m, $e, $n);;

		return $c;
	}

	public function decrypt($key, $c)
	{
		$d =  $key['privateKey'][1];
		$n = $key['publicKey'][0];
		$res = $this->Mode($c, $d, $n);
		
		return $res;
	}
	 
	public function createKey()
	{
		$a = array();
		for($i = 1000; $i < 3000; $i++) {
			$primes = 0;
			for($k = 1; $k <= $i; $k++)
			if($i%$k === 0) $primes++;
			if($primes <= 2) // 能除以1和自身的整数(不包括0)
			$a[] = $i;
		}
		
		$p = $a[mt_rand(0,count($a)-1)];
		$q = $a[mt_rand(0,count($a)-1)];

		$n = $p * $q;

		$res = $this->Euler($n);
		
		$re = array();
		foreach($a as $v){
			if($v<$res && $v > 1) {
				$re[] = $v;
			}
		}

		$e = $re[mt_rand(0,count($re)-1)]; // 1< e < 欧拉函数(n)
		
		$d = $this->cal($e,$res,1);

		$public = array($n, $e);
		$private = array($n, $d);

		return array('publicKey'=>$public, 'privateKey'=>$private);
	}

	public function Euler($x)
	{
		$res = $x;
		$now = 2;
		while ($x > 1) {
			if ($x % $now == 0) {
				$res /= $now;
				$res *= ($now - 1);
				while ($x % $now == 0) {
					$x /= $now;
				}
			}
			$now++;
		}
		return $res;
	}

	public function e_gcd($a, $b, &$x, &$y)
	{
		if($b==0)
		{
			$x=1;
			$y=0;
			return $a;
		}
		$ans=$this->e_gcd($b,$a%$b,$x,$y);
		$temp=$x;
		$x=$y;
		$y=$temp-floor($a/$b)*$y;
		return $ans;
	}

	public function cal($a, $b, $c)
	{
		$x = 0;
		$y = 0;
		$gcd = $this->e_gcd($a,$b,$x,$y);
		if($c%$gcd!=0) return -1;
		$x*=$c/$gcd;
		$b/=$gcd;
		if($b<0) $b=-$b;
		$ans=$x%$b;
		if($ans<=0) $ans+=$b;
		return $ans;
	}

	public function Mode($a, $b, $mode)
	{
		$sum = 1;
		while ($b) 
		{
			if ($b & 1) 
			{
				$sum = ($sum * $a) % $mode;
				$b--;
			}
			$b /= 2;
			$a = $a * $a % $mode;
		}
		return $sum;
	}
	
	public function encrypt_data($key, $data)
	{
			
		$test = bin2hex($data);

		$enc = array();
		for($i=0;$i<strlen($test);$i++) {
			$t = ord( substr($test, $i, 1) );
			 $str = $this->encrypt($key, $t);
			 
			 $z = 10-strlen($str);
			 for($t=0;$t<$z;$t++) {
				$str= '0'.$str;
			 }
			 $enc[] = $str;
			 
			
		}
		return join('', $enc);
	}

	public function decrypt_data($key, $encrypt)
	{
		$encrypt_arr = array();
		$i=0;
		do{
			if($arr = substr($encrypt,$i, 10)) {
				
				$encrypt_arr[] = (int)$arr;
			}
			$i+=10;
		}
		while($arr);
		
		$jay = array();
		foreach($encrypt_arr as $v) {
			$jay[] = chr($this->decrypt($key, $v));
		}
		$jayc = join('', $jay);


		return (hex2bin($jayc)."\n");

	}
	
};
