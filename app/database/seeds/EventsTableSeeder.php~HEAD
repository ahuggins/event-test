<?php

class EventsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('events')->delete();


        $events = array(
            array(
                'title'      => 'Pint Night at Pazzos!',
                'start_time' => new DateTime,
                'end_time' => new DateTime,
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
                'start_time' => new DateTime,
                'end_time' => new DateTime,
                'location'   => 'demo lat-log',
                'created_by'   => 'Nick Such',
                'hosted_by'   => 'Awesome Inc',
                'event_type' => 'Competition',
                'description'   => '5 Across is an informal gathering of entrepreneurs, investors, and service providers from Lexington, KY. Each 5 Across meeting features presentations from local entrepreneurs who pitch their ideas to a panel of judges.',
                'is_private' => 0,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('events')->insert( $events );
    }

}
