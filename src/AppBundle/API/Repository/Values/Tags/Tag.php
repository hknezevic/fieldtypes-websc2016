<?php

namespace AppBundle\API\Repository\Values\Tags;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Class representing a tag.
 *
 * @property-read mixed $id Tag ID
 * @property-read mixed $parentTagId Parent tag ID
 * @property-read mixed $mainTagId Main tag ID
 * @property-read string $keyword Convenience getter for $this->getKeyword() and BC layer
 * @property-read string $keywords Tag keywords
 * @property-read int $depth The depth tag has in tag tree
 * @property-read string $pathString The path to this tag e.g. /1/6/21/42 where 42 is the current ID
 * @property-read \DateTime $modificationDate Tag modification date
 * @property-read string $remoteId A global unique ID of the tag
 * @property-read boolean $alwaysAvailable Indicates if the Tag object is shown in the main language if it is not present in an other requested language
 * @property-read string $mainLanguageCode The main language code of the Tag object
 * @property-read string[] $languageCodes List of languages in this Tag object
 */
class Tag extends ValueObject
{
}
