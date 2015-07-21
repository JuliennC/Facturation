<?php

namespace JC\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class JCUserBundle extends Bundle
{
	public function getParent() {
    return 'FOSUserBundle';
  }
  
}
