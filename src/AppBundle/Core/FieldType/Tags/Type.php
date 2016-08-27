<?php

namespace AppBundle\Core\FieldType\Tags;

use AppBundle\API\Repository\Values\Tags\Tag;
use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\Core\FieldType\Value as BaseValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use DateTime;
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
        return 'eztags';
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
        return (string)$value;
    }

    /**
     * Returns the empty value for this field type.
     *
     * @return \AppBundle\Core\FieldType\Tags\Value
     */
    public function getEmptyValue()
    {
        return new Value();
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
        return $value === null || $value->tags == $this->getEmptyValue()->tags;
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
        if (is_array($inputValue)) {
            foreach ($inputValue as $inputValueItem) {
                if (!$inputValueItem instanceof Tag) {
                    return $inputValue;
                }
            }

            $inputValue = new Value($inputValue);
        }

        return $inputValue;
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
        if (!is_array($value->tags)) {
            throw new InvalidArgumentType(
                '$value->tags',
                'array',
                $value->tags
            );
        }

        foreach ($value->tags as $tag) {
            if (!$tag instanceof Tag) {
                throw new InvalidArgumentType(
                    "$tag",
                    'AppBundle\\Core\\FieldType\\Tags\\Value',
                    $tag
                );
            }
        }
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
        if (!is_array($hash)) {
            return new Value();
        }

        $tags = array();

        foreach ($hash as $hashItem) {
            if (!is_array($hashItem)) {
                continue;
            }

            $modificationDate = new DateTime();
            $modificationDate->setTimestamp($hashItem['modified']);

            $tags[] = new Tag(
                array(
                    'id' => $hashItem['id'],
                    'parentTagId' => $hashItem['parent_id'],
                    'mainTagId' => $hashItem['main_tag_id'],
                    'keywords' => $hashItem['keywords'],
                    'depth' => $hashItem['depth'],
                    'pathString' => $hashItem['path_string'],
                    'modificationDate' => $modificationDate,
                    'remoteId' => $hashItem['remote_id'],
                    'alwaysAvailable' => $hashItem['always_available'],
                    'mainLanguageCode' => $hashItem['main_language_code'],
                    'languageCodes' => $hashItem['language_codes'],
                )
            );
        }

        return new Value($tags);
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
        $hash = array();

        foreach ($value->tags as $tag) {
            $hash[] = array(
                'id' => $tag->id,
                'parent_id' => $tag->parentTagId,
                'main_tag_id' => $tag->mainTagId,
                'keywords' => $tag->keywords,
                'depth' => $tag->depth,
                'path_string' => $tag->pathString,
                'modified' => $tag->modificationDate->getTimestamp(),
                'remote_id' => $tag->remoteId,
                'always_available' => $tag->alwaysAvailable,
                'main_language_code' => $tag->mainLanguageCode,
                'language_codes' => $tag->languageCodes,
            );
        }

        return $hash;
    }

    /**
     * Returns information for FieldValue->$sortKey relevant to the field type.
     *
     * @param \AppBundle\Core\FieldType\Tags\Value $value
     *
     * @return bool
     */
    protected function getSortInfo(BaseValue $value)
    {
        return false;
    }

    /**
     * Returns whether the field type is searchable.
     *
     * @return bool
     */
    public function isSearchable()
    {
        return true;
    }
}
