<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class PenguinsBackendApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_PENGUINS = 'penguins';

    /**
     * @api
     *
     * @var string
     */
    public const RESPONSE_CODE_BAD_REQUEST = '9400';

    /**
     * @api
     *
     * @var string
     */
    public const RESPONSE_CODE_PENGUIN_NOT_FOUND = '9404';

    /**
     * @api
     *
     * @var string
     */
    public const RESPONSE_CODE_WRONG_REQUEST_BODY = '9412';

    /**
     * @api
     *
     * @var string
     */
    public const RESPONSE_DETAIL_BAD_REQUEST = 'Generic bad request.';

    /**
     * @api
     *
     * @var string
     */
    public const RESPONSE_DETAIL_PENGUIN_NOT_FOUND = 'Penguin not found.';

    /**
     * @api
     *
     * @var string
     */
    public const RESPONSE_DETAIL_WRONG_REQUEST_BODY = 'Wrong request body.';
}
