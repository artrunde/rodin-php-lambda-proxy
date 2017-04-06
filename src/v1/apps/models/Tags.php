<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class Tags extends ODM {

	public $tag_id;

	public $place_id;

	public $category;

	protected $_table_name = 'rodin_tags_v1';

	protected $_hash_key   = 'tag_id';

    protected $_range_key  = 'place_id';

	protected $_schema = array(
		'tag_id'    => 'S',    // search_term is number
		'place_id'  => 'S',    // type is string
		'category'  => 'S'
	);

    public static function createQueryPlaceResult($tags) {

        $resultArray    = array();
        $i              = 0;

        /**
         *  Go through each searchable and query all items tagged
         */
        foreach ($tags as $searchable) {

            /**
             * @var Tags $data
             */
            $data = Tags::factory('RodinAPI\Models\Tags')
                ->where('tag_id', '=', $searchable)
                ->findMany();

            foreach ($data as $tag) {
                $resultArray[$i][$tag->place_id] = $searchable;
            }

            $i++;
        }

        return $resultArray;

    }

}