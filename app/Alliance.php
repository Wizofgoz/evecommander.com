<?php

namespace App;

use App\Abstracts\Organization;
use Illuminate\Support\Carbon;

/**
 * Class Alliance.
 *
 * @property string id
 * @property int api_id
 * @property string name
 * @property string default_membership_level
 * @property array settings
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * Relationships
 * @property \Illuminate\Database\Eloquent\Collection handbooks
 * @property \Illuminate\Database\Eloquent\Collection members
 * @property MembershipLevel defaultMembershipLevel
 * @property \Illuminate\Database\Eloquent\Collection membershipLevels
 * @property \Illuminate\Database\Eloquent\Collection memberships
 * @property \Illuminate\Database\Eloquent\Collection replacementClaims
 * @property \Illuminate\Database\Eloquent\Collection invoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultInvoices
 * @property \Illuminate\Database\Eloquent\Collection receivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection fulfilledReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection overdueReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection pendingReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection defaultReceivedInvoices
 * @property \Illuminate\Database\Eloquent\Collection notifications
 * @property \Illuminate\Database\Eloquent\Collection readNotifications
 * @property \Illuminate\Database\Eloquent\Collection unreadNotifications
 * @property Coalition coalition
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection corporations
 */
class Alliance extends Organization
{
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Get relation between this alliance and the coalition it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function coalition()
    {
        return $this->memberships()->where('organization_type', Coalition::class)->with('organization');
    }

    /**
     * Get relation between this alliance and any corporations that belong to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function corporations()
    {
        return $this->members()->where('member_type', Corporation::class)->with('member');
    }
}
