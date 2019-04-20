<?php

namespace App\JsonApi\Validators;

use App\MembershipFee;
use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;
use Illuminate\Validation\Rule;

class MembershipFeeValidator extends AbstractValidators
{
    /**
     * @var string
     */
    protected $resourceType = 'membership-fees';

    /**
     * The include paths a client is allowed to request.
     *
     * @var string[]|null
     *      the allowed paths, an empty array for none allowed, or null to allow all paths.
     */
    protected $allowedIncludePaths = null;

    /**
     * The sort field names a client is allowed send.
     *
     * @var string[]|null
     *      the allowed fields, an empty array for none allowed, or null to allow all fields.
     */
    protected $allowedSortParameters = [
        'created-at'
    ];

    /**
     * Get resource validation rules.
     *
     * @param mixed|null $record
     *      the record being updated, or null if creating a resource.
     * @return array
     */
    protected function rules($record = null): array
    {
        return [
            'name' => 'required|string',
            'amount-type' => [
                'required',
                'string',
                Rule::in(MembershipFee::ALLOWED_TYPES)
            ],
            'amount' => 'required|numeric'
        ];
    }

    /**
     * Get query parameter validation rules.
     *
     * @return array
     */
    protected function queryRules(): array
    {
        return [
            //
        ];
    }
}
