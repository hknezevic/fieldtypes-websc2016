<?php

namespace AppBundle\Core\FieldType\Tags;

use eZ\Publish\Core\FieldType\Value as BaseValue;
use AppBundle\API\Repository\Values\Tags\Tag;

/**
 * Value for Tags field type.
 */
class Value extends BaseValue
{
    /**
     * @var \AppBundle\API\Repository\Values\Tags\Tag[]
     */
    public $tags = array();

    /**
     * Constructor.
     *
     * @param \AppBundle\API\Repository\Values\Tags\Tag[] $tags
     */
    public function __construct($tags = null)
    {
        if (is_array($tags)) {
            $this->tags = $tags;
        }
    }

    /**
     * Returns a string representation of the field value.
     *
     * @return string
     */
    public function __toString()
    {
        return implode(
            ', ',
            array_map(
                function (Tag $tag) {
                    return $tag->getKeyword();
                },
                $this->tags
            )
        );
    }
}
