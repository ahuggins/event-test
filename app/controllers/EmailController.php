<?php 

/**
* Email Controller
*/
class EmailController extends BaseController
{
	// Currently not in use. AH 11/15/14
	// Couldn't get it working, but I think this is better location than the Users controller.
	public function sendWelcome($data)
	{
		Mail::send('emails/app/welcome', [], function($message)
		{
			$message->to(Input::get('email'))->subject('Events testing with Mandrill');
		});
	}
}