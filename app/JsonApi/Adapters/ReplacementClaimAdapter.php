<?php

namespace App\JsonApi\Adapters;

use App\JsonApi\FiltersResources;
use App\ReplacementClaim;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;

class ReplacementClaimAdapter extends AbstractAdapter
{
    use FiltersResources;

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    protected $guarded = [];

    /**
     * Resource relationship fields that can be filled.
     *
     * @var array
     */
    protected $relationships = [
        'character',
        'organization',
        'comments',
        'notifications',
        'lastUpdatedBy',
    ];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new ReplacementClaim(), $paging);
    }

    public function character()
    {
        return $this->belongsTo();
    }

    public function organization()
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

    public function lastUpdatedBy()
    {
        return $this->belongsTo();
    }
}
