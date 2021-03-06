<?php

namespace App;

use App\Abstracts\Organization;
use App\Traits\HasComments;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Fitting.
 *
 * @property string id
 * @property string organization_id
 * @property string organization_type
 * @property string name
 * @property string description
 * @property int api_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection comments
 * @property Doctrine doctrine
 * @property Organization organization
 * @property \Illuminate\Database\Eloquent\Collection replacementClaims
 */
class Fitting extends Model
{
    use UuidTrait, HasComments;

    /**
     * Get relation between this fitting and the doctrine it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctrine()
    {
        return $this->belongsTo(Doctrine::class);
    }

    /**
     * Get relation between this fitting and the organization that owns it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function organization()
    {
        return $this->morphTo();
    }

    /**
     * Get relation between this fitting and any replacement claims that are regarding it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replacementClaims()
    {
        return $this->hasMany(ReplacementClaim::class);
    }
}
