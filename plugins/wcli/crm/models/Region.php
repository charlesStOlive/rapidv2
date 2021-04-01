<?php namespace Wcli\Crm\Models;

use Model;

/**
 * region Model
 */

class Region extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    use \Waka\Utils\Classes\Traits\DataSourceHelpers;
    use \Waka\Segator\Classes\Traits\TagTrait;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wcli_crm_regions';


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required',
        'email' => 'required',
    ];

    public $customMessages = [
    ];

    /**
     * @var array attributes send to datasource for creating document
     */
    public $attributesToDs = [
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [
    ];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'clients' => [
            'Wcli\Crm\Models\Client',
        ],
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [
        'sales' => [
            'Wcli\Crm\Models\Sale',
            'through' => 'Wcli\Crm\Models\Client',
        ],

    ];
    public $belongsTo = [
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [
        'unique' => [
            'Waka\Wconfig\Models\UniqueAgg',
            'name' => 'uniqueable',
        ],
    ];
    public $morphMany = [
        'aggs' => [
            'Waka\Agg\Models\Aggeable',
            'name' => 'aggeable',
        ],
    ];
    public $attachOne = [
    ];
    public $attachMany = [
    ];

    /**
     *EVENTS
     **/

    /**
     * LISTS
     **/

    /**
     * GETTERS
     **/

    /**
     * SCOPES
     */

    /**
     * SETTERS
     */
 
    /**
     * FILTER FIELDS
     */

    /**
     * OTHERS
     */
    
}