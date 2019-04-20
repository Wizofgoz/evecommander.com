<?php

namespace App\JsonApi\Schemas;

use App\JsonApi\ProvidesMeta;
use Neomerx\JsonApi\Schema\SchemaProvider;

class AllianceSchema extends SchemaProvider
{
    use ProvidesMeta;

    /**
     * @var string
     */
    protected $resourceType = 'alliances';

    /**
     * @param \App\Alliance $resource
     *                                the domain record being serialized.
     *
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Alliance $resource
     *                                the domain record being serialized.
     *
     * @return array
     */
    public function getAttributes($resource)
    {
        return [
            'api-id'             => $resource->api_id,
            'name'               => $resource->name,
            'settings'           => $resource->settings,
            'created-at'         => $resource->created_at->toIso8601String(),
            'updated-at'         => $resource->updated_at->toIso8601String(),
        ];
    }

    /**
     * @param \App\Alliance $resource
     * @param bool          $isPrimary
     * @param array         $includeRelationships
     *
     * @return array
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'handbooks' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->handbooksCount($resource);
                },
            ],

            'members' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->membersCount($resource);
                },
            ],

            'default-membership-level' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
            ],

            'membership-levels' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->membershipLevelsCount($resource);
                },
            ],

            'memberships' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->membershipsCount($resource);
                },
            ],

            'replacement-claims' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->replacementClaimsCounts($resource);
                },
            ],

            'issued-invoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->issuedInvoicesCounts($resource);
                },
            ],

            'received-invoices' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->receivedInvoicesCounts($resource);
                },
            ],

            'notifications' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->notificationsCounts($resource);
                },
            ],

            'coalition' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships['coalition']),
                self::DATA         => function () use ($resource) {
                    return $resource->coalition;
                },
            ],

            'roles' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->rolesCount($resource);
                },
            ],

            'subscriptions' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return $this->subscriptionsCount($resource);
                },
            ],

            'corporations' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->corporations->count(),
                    ];
                },
            ],

            'fleets' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->fleets->count(),
                    ];
                },
            ],

            'fleet-types' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->fleetTypes->count(),
                    ];
                },
            ],

            'billing-conditions' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->billingConditions->count(),
                    ];
                },
            ],

            'billing-condition-groups' => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::META         => function () use ($resource) {
                    return [
                        'count' => $resource->billingConditionGroups->count(),
                    ];
                },
            ],
        ];
    }
}
