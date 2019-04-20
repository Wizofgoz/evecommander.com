<?php

namespace App\JsonApi\Adapters;

use App\Fleet;
use App\JsonApi\FiltersResources;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Facades\Auth;

class FleetAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [
        'api-id',
        'created-by',
        'last-updated-by',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Fleet(), $paging);
    }

    public function fleetType()
    {
        return $this->belongsTo();
    }

    public function organization()
    {
        return $this->belongsTo();
    }

    public function createdBy()
    {
        return $this->belongsTo();
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo();
    }

    public function comments()
    {
        return $this->hasMany();
    }

    public function notifications()
    {
        return $this->hasMany();
    }

    public function rsvps()
    {
        return $this->hasMany();
    }

    public function trackerCharacter()
    {
        return $this->belongsTo();
    }

    public function members()
    {
        return $this->hasMany();
    }

    public function wings()
    {
        return $this->hasMany();
    }

    public function squads()
    {
        return $this->hasMany();
    }

    protected function creating(Fleet $fleet)
    {
        $fleet->createdBy()->associate(Auth::user());
    }

    protected function updating(Fleet $fleet)
    {
        $fleet->lastUpdatedBy()->associate(Auth::user());
    }
}
