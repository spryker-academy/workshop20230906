<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\PenguinsBackendApi\Plugin\GlueBackendApiApplication;

use Generated\Shared\Transfer\GlueResourceMethodCollectionTransfer;
use Generated\Shared\Transfer\GlueResourceMethodConfigurationTransfer;
use Generated\Shared\Transfer\PenguinsBackendApiAttributesTransfer;
use Pyz\Glue\PenguinsBackendApi\Controller\PenguinsResourceController;
use Pyz\Glue\PenguinsBackendApi\PenguinsBackendApiConfig;
use Spryker\Glue\GlueApplication\Plugin\GlueApplication\Backend\AbstractResourcePlugin;
use Spryker\Glue\GlueJsonApiConventionExtension\Dependency\Plugin\JsonApiResourceInterface;

class PenguinsBackendResourcePlugin extends AbstractResourcePlugin implements JsonApiResourceInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getType(): string
    {
        return PenguinsBackendApiConfig::RESOURCE_PENGUINS;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getController(): string
    {
        return PenguinsResourceController::class;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\GlueResourceMethodCollectionTransfer
     */
    public function getDeclaredMethods(): GlueResourceMethodCollectionTransfer
    {
        return (new GlueResourceMethodCollectionTransfer())
            ->setGetCollection(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAttributes(PenguinsBackendApiAttributesTransfer::class),
            )
            ->setGet(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAttributes(PenguinsBackendApiAttributesTransfer::class),
            )
            ->setPost(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAttributes(PenguinsBackendApiAttributesTransfer::class),
            )
            ->setPatch(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAttributes(PenguinsBackendApiAttributesTransfer::class),
            )
            ->setDelete(
                (new GlueResourceMethodConfigurationTransfer())
                    ->setAttributes(PenguinsBackendApiAttributesTransfer::class),
            );
    }
}
