<?php

class TagsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('tags')->delete();


        $tags = array(
            array(
                'tag_text'      => 'Beer',
                'filter_text'   => 'beer',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'tag_text'      => 'Music',
                'filter_text'   => 'music',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'tag_text'      => 'Food Truck',
                'filter_text'   => 'food-truck',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'tag_text'      => 'Art',
                'filter_text'   => 'art',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'tag_text'      => 'Sports',
                'filter_text'   => 'sports',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'tag_text'      => 'Tech',
                'filter_text'   => 'tech',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'tag_text'      => 'Networking',
                'filter_text'   => 'networking',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'tag_text'      => 'Food',
                'filter_text'   => 'food',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'tag_text'      => 'Trivia',
                'filter_text'   => 'trivia',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('tags')->insert( $tags );
    }

}
