<?php

namespace Registry\Views;

use Registry\Models\MemberModel;

class SelectMemberView
{
	public function getSelectedMember() 
	{
		$member = new MemberModel(1, "Johan", 1234567890);
		return $member;
	}
}
	