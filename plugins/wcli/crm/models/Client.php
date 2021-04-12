<?php namespace Wcli\Crm\Models;

use Model;

/**
 * client Model
 */

class Client extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \Waka\Utils\Classes\Traits\DataSourceHelpers;
    use \Waka\Segator\Classes\Traits\TagTrait;
    use \Wcli\Wconfig\Functions\Traits\Helpers;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wcli_crm_clients';


    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'required',
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
        'sales' => [
            'Wcli\Crm\Models\Sale',
            'delete' => 'true',
        ],
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [
    ];
    public $belongsTo = [
        'region' => [
            'Wcli\Crm\Models\Region',
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [
        'unique' => [
            'Wcli\Wconfig\Models\UniqueAgg',
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
    public function getSalesByGammes($periode) {
        if(!$periode) {
            throw new \SystemException('variable periode est null');
        }
        $sales = $this->sales();
        $sales = $this->filterByPeriode($sales, $periode);
        if(!$sales) {
            return null;
        }
        $sales =  $sales->select('gamme_id', \Db::raw('COUNT(*) as value'))
            ->groupBy('gamme_id')->get();
        $sales = $sales->map(function ($item, $key)  {
            $mapped = [];
            if ($item['gamme_id'] != 'autres') {
                $mapped['labels'] = Gamme::find($item['gamme_id'])->name;
            }
            $mapped['value'] = $item['value'];
            return $mapped;
        });
        return $sales;

    }
    public function getSalesByGammesLabels($attributes) {
        $periode = $attributes['periode'];
        $sales =  $this->getSalesByGammes($periode);
        if(!$sales) {
            return [];
        }
        return $sales->pluck('labels')->toArray();
    }
    public function getSalesByGammesValue($attributes) {
        $periode = $attributes['periode'];
        $sales =  $this->getSalesByGammes($periode);
        if(!$sales) {
            return [];
        }
        return $sales->pluck('value')->toArray();
    }
    public function getSales($attributes) {
        $results = $this->aggs()
            ->where('type', $attributes['type'])
            ->orderBy('ended_at', 'desc')->take($attributes['take'])->get();
            return $results->sortBy('ended_at');
    }
    public function getSalesLabels($attributes) {
        $sales = $this->getSales($attributes);
        $labels = [];
        foreach ($sales as $key => $result) {
            array_push($labels, $result->year . '-' . $attributes['type'] . '-' . $result->num);
        }
        return $labels;
    }
    public function getSalesValue($attributes) {
        $sales = $this->getSales($attributes);
        $dataSet = [];
        foreach ($sales as $key => $result) {
            array_push($dataSet, $result[$attributes['calcul']]);
        }
        return $dataSet;
    }

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
