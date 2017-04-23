<?php

namespace RodinAPI\Models;

use RodinAPI\Library\ODM;

class SearchTerm extends ODM {

	public $search_term;

	public $label;

    public $belongs_to;

    public $create_time;

	protected $_table_name = 'rodin_search_terms_v1';

	protected $_hash_key = 'search_term';

    protected $_range_key = 'label';

	protected $_schema = array(
        'search_term'   => 'S',
        'label'         => 'S',
        'belongs_to'    => 'S',
        'create_time'   => 'S'
	);

	public function getLabel() {
	    return explode('_', $this->label)[1];
    }

    public function getType() {
        return explode('_', $this->label)[0];
    }

    /**
     * @param $search_term
     * @param $label
     * @param $belongs_to
     * @return $this
     */
    public static function createSearchTerm( $search_term, $label, $belongs_to )
    {

        $searchTerm = SearchTerm::factory('RodinAPI\Models\SearchTerm')->create();

        $searchTerm->search_term    = strtolower($search_term);
        $searchTerm->label          = $label;
        $searchTerm->belongs_to     = $belongs_to;
        $searchTerm->create_time    = date('c');

        $searchTerm->save();

        return $searchTerm;
    }

    /**
     * @param $belongs_to
     * @return bool
     */
    public static function deleteSearchTerm($belongs_to)
    {

        $deleted = false;

        $terms = SearchTerm::factory('RodinAPI\Models\SearchTerm')->where('belongs_to','=',$belongs_to)->index('BelongsToSearchTermIndex')->findMany();

        foreach( $terms as $term ) {
            $deleted = SearchTerm::factory('RodinAPI\Models\SearchTerm')->findOne($term->search_term, $term->label)->delete();
        }

        return $deleted;

    }

}