<?php namespace Wcli\Crm\Models;

use Model;

/**
 * gamme Model
 */

class Gamme extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wcli_crm_gammes';


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
        'slug' => 'required',
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
        ],
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [
        
    ];
    public $belongsTo = [
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [
    ];
    public $morphMany = [
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
    public function getNbSalesMontantAttribute()
    {
        $ids = [$this->id];
        $childId = $this->findChildIds($this, $ids);
        $total = Sale::whereIn('gamme_id', $childId)->count();
        $sum = Sale::whereIn('gamme_id', $childId)->sum('montant');
        return 'nb : ' . $total . ' / ' . number_format($sum, 0, ',', ' ') . '€';
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
    public function getThisParentValue($value)
    {
        if ($this->{$value}) {
            return $this->{$value};
        } else {
            $parents = $this->getParents()->sortByDesc('nest_depth');
            foreach ($parents as $parent) {
                if ($parent->{$value} != null) {
                    return $parent->{$value};
                }
            }
        }
    }

    public function findChildIds($child, $ids)
    {
        if (isset($child->children)) {
            if (count($child->children) > 0) {
                foreach ($child->children as $ch) {
                    array_push($ids, $ch->id);
                    $ids = $this->findChildIds($ch, $ids);
                }
            }
        }

        return $ids;
    }

}
