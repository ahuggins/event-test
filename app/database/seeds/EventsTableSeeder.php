<?php

class EventsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('events')->delete();


        $events = array(
            array(
                'title'      => 'Pint Night at Pazzos!',
                'start_time' => date('Y-m-d H:i:s', strtotime('+1 hour')),
                'end_time' => date('Y-m-d H:i:s', strtotime('+2 hours')),
                'location'   => 'demo lat-log',
                'created_by'   => 'John Smith',
                'hosted_by'   => 'Pazzos Pizza Pub',
                'event_type' => 'Promotion Drinking Event',
                'description'   => ' Serving the best hand-tossed pizza in Lexington and the largest draft selection in Central Kentucky! 47 Beers On Draught!',
                'is_private' => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => '5Across',
                'start_time' => date('Y-m-d H:i:s', strtotime('+2 hours')),
                'end_time' => date('Y-m-d H:i:s', strtotime('+3 hours')),
                'location'   => 'demo lat-log',
                'created_by'   => 'Nick Such',
                'hosted_by'   => 'Awesome Inc',
                'event_type' => 'Competition',
                'description'   => '5 Across is a gathering of entrepreneurs, investors, and service providers from Lexington, KY where entrepreneurs pitch their ideas to a panel of judges.',
                'is_private' => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => '$4 Flight Night @ Whole Foods',
                'start_time' => date('Y-m-d H:i:s', strtotime('+1 day 1 hours')),
                'end_time' => date('Y-m-d H:i:s', strtotime('+1 day 2 hours')),
                'location'   => 'demo lat-log',
                'created_by'   => 'Lex.Events',
                'hosted_by'   => 'Whole Foods',
                'event_type' => 'Promotion Drinking Event',
                'description'   => 'Delicious beer and food pairings every Friday at the Lexington Green Whole Foods location. A great happy hour event to start your weekend!',
                'is_private' => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => 'Led Zeppelin',
                'start_time' => date('Y-m-d H:i:s', strtotime('+3 days 4 hours')),
                'end_time' => date('Y-m-d H:i:s', strtotime('+3 days 6 hours')),
                'location'   => 'demo lat-log',
                'created_by'   => 'Cosmic Charlies',
                'hosted_by'   => 'Cosmic Charlies',
                'event_type' => 'Music',
                'description'   => 'Rock your asses off with the legendary Led Zeppelin at Cosmic Charlies. One night only. Don\'t miss out! ',
                'is_private' => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'title'      => '31 Days in future',
                'start_time' => date('Y-m-d H:i:s', strtotime('+31 days 4 hours')),
                'end_time' => date('Y-m-d H:i:s', strtotime('+31 days 6 hours')),
                'location'   => 'demo lat-log',
                'created_by'   => 'Cosmic Charlies',
                'hosted_by'   => 'Cosmic Charlies',
                'event_type' => 'Music',
                'description'   => 'Rock your asses off with the legendary Led Zeppelin at Cosmic Charlies. One night only. Don\'t miss out! ',
                'is_private' => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('events')->insert( $events );
    }

}
