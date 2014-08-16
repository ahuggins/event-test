<?php

class EventsTagsRelationTableSeeder extends Seeder {

    public function run()
    {
        DB::table('events-tags-relation')->delete();


        $data = array(
            array(
                'events_id'      => '1',
                'tags_id'   => '1'
            ),
            array(
                'events_id'      => '1',
                'tags_id'   => '2'
            ),
            array(
                'events_id'      => '1',
                'tags_id'   => '5'
            ),
            array(
                'events_id'      => '1',
                'tags_id'   => '7'
            ),
            array(
                'events_id'      => '2',
                'tags_id'   => '6'
            ),
            array(
                'events_id'      => '2',
                'tags_id'   => '7'
            ),
            array(
                'events_id'      => '3',
                'tags_id'   => '1'
            ),
            array(
                'events_id'      => '3',
                'tags_id'   => '8'
            ),
            array(
                'events_id'      => '3',
                'tags_id'   => '7'
            ),
            array(
                'events_id'      => '4',
                'tags_id'   => '2'
            ),
            array(
                'events_id'      => '4',
                'tags_id'   => '1'
            )

        );

        DB::table('events-tags-relation')->insert( $data );
    }

}
