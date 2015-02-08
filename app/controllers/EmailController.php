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

	public function summary()
	{
		$users = User::all();
		foreach( $users as $user ) {

			$attends = [];
			$attending = EventsUsers::attending($user->id);

			foreach ($attending as $attend) {
				$attends[] = $attend->events_id;
			}

			if (!empty($attends)) {

				$events = Events::whereIn('id', $attends)->orderBy('start_time', 'ASC')->get();
				
				Mail::send('emails.app.summary', ['events' => $events, 'user' => $user], function( $message ) use ( $user ) 
				{
					$message->to($user->email)->subject('Lex.events weekly events!');
				});

			}
		}
	}

	public function signUps()
	{
		$users = User::whereBetween('created_at', array( 
						date('Y-m-d', strtotime('-7 days')), 
						date('Y-m-d', strtotime('now'))) )
						->get();
		Mail::send('emails.app.summary-sign-ups', ['users' => $users], function( $message ) use ( $users ) 
		{
			$message->to('andrewhuggins@gmail.com')->subject('Lex.events weekly sign ups!');
		});
		// return View::make('emails.app.summary-sign-ups', ['users' => $users]);
		// return $users;
	}

}