<?php

namespace LearnosityQti\Tests\Unit\Processors\QtiV2\In\Fixtures;

use qtism\common\datatypes\QtiDirectedPair;
use qtism\data\state\CorrectResponse;
use qtism\data\state\MapEntry;
use qtism\data\state\MapEntryCollection;
use qtism\data\state\Mapping;
use qtism\data\state\ResponseDeclaration;
use qtism\data\state\Value;
use qtism\data\state\ValueCollection;

class ResponseDeclarationBuilder
{
    public static function buildWithCorrectResponse($identifier, array $values)
    {
        $responseDeclaration = new ResponseDeclaration($identifier);
        $valueCollection = new ValueCollection();
        foreach ($values as $value) {
            $valueCollection->attach(new Value($value));
        }
        $responseDeclaration->setCorrectResponse(new CorrectResponse($valueCollection));
        return $responseDeclaration;
    }

    /**
     * @param string $identifier
     * @param array $mapping Mapping of `mapKey` to [`mappedValue`, `caseSensitive`]
     * ie. {
     *      "York" => [1, false]
     *      "york" => [1, false]
     *      "Manhattan" => [1, true]
     * }
     *
     * @return \qtism\data\state\ResponseDeclaration
     */
    public static function buildWithMapping($identifier, array $mapping, $mapEntryKeyType = null)
    {
        $responseDeclaration = new ResponseDeclaration($identifier);
        $mapEntryCollection = new MapEntryCollection();
        foreach ($mapping as $mapKey => $values) {
            $mappedValue = $values[0];
            $caseSensitive = isset($values[1]) ? $values[1] : false;
            if ($mapEntryKeyType) {
                $keyParts = explode(' ', $mapKey);
                $mapKey = new QtiDirectedPair($keyParts[0], $keyParts[1]);
            }
            $mapEntryCollection->attach(new MapEntry($mapKey, floatval($mappedValue), $caseSensitive));
        }
        $responseDeclaration->setMapping(new Mapping($mapEntryCollection));
        return $responseDeclaration;
    }
}
