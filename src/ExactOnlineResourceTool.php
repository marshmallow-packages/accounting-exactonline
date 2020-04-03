<?php

namespace Marshmallow\ExactOnline;

use Laravel\Nova\ResourceTool;

class ExactOnlineResourceTool extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Exact Online Resource Tool';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'exact-online-resource-tool';
    }
}
