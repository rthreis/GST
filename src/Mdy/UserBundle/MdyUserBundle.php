<?php
// src/Mdy/UserBundle/MdyUserBundle.php

namespace Mdy\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MdyUserBundle extends Bundle{
	
	public function getParent(){
		return 'FOSUserBundle';
	}
}