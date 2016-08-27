<?php

namespace AppBundle\Core\FieldType\Tags;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\Core\FieldType\Value as BaseValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
/**
 * Tags field type.
 *
 * Represents tags.
 */
class Type extends FieldType
{
    /**
     * Returns the field type identifier for this field type.
     *
     * @return string
     */
    public function getFieldTypeIdentifier()
    {
    }

    /**
     * Returns a human readable string representation from the given $value.
     *
     * @param \AppBundle\Core\FieldType\Tags\Value $value
     *
     * @return string
     */
    public function getName(SPIValue $value)
    {
    }

    /**
     * Returns the empty value for this field type.
     *
     * @return \AppBundle\Core\FieldType\Tags\Value
     */
    public function getEmptyValue()
    {
    }

    /**
     * Returns if the given $value is considered empty by the field type.
     *
     * @param \AppBundle\Core\FieldType\Tags\Value $value
     *
     * @return bool
     */
    public function isEmptyValue(SPIValue $value)
    {
    }

    /**
     * Inspects given $inputValue and potentially converts it into a dedicated value object.
     *
     * @param mixed $inputValue
     *
     * @return \AppBundle\Core\FieldType\Tags\Value The potentially converted and structurally plausible value.
     */
    protected function createValueFromInput($inputValue)
    {
    }

    /**
     * Throws an exception if value structure is not of expected format.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If the value does not match the expected structure.
     *
     * @param \AppBundle\Core\FieldType\Tags\Value $value
     */
    protected function checkValueStructure(BaseValue $value)
    {
    }

    /**
     * Converts an $hash to the Value defined by the field type.
     *
     * @param mixed $hash
     *
     * @return \AppBundle\Core\FieldType\Tags\Value
     */
    public function fromHash($hash)
    {
    }

    /**
     * Converts the given $value into a plain hash format.
     *
     * @param \AppBundle\Core\FieldType\Tags\Value $value
     *
     * @return array
     */
    public function toHash(SPIValue $value)
    {
    }
}
