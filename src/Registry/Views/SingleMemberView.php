<?php

namespace Registry\Views;

use Registry\Models\MemberModel;

class SingleMemberView
{
	public function printMemberData(MemberModel $member) 
	{
		$memberID = $member->getMemberID();
		$name = $member->getName();
		$ssn = $member->getSocialSecurityNumber();
		
		print "
				MemberID : $memberID \n
				Name : $name \n
				SSN : $ssn \n
		";
	}
	
}
	