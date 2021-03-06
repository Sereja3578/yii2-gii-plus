<?php

use pvsaintpe\gii\plus\helpers\Helper;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $generator pvsaintpe\gii\plus\generators\fixture\Generator */
/* @var $ns string */
/* @var $modelName string */
/* @var $modelClass string|pvsaintpe\boost\db\ActiveRecord */
/* @var $fixtureNs string */
/* @var $fixtureName string */
/* @var $fixtureClass string */
/* @var $baseFixtureName string */
/* @var $baseFixtureClass string */
/* @var $dataFile string */
/* @var $tableSchema pvsaintpe\db\components\TableSchema */

$uses = [
    $baseFixtureClass
];
Helper::sortUses($uses);

echo '<?php

namespace ', $fixtureNs, ';

use ', implode(';' . "\n" . 'use ', $uses), ';

/**
 * ', Inflector::titleize($fixtureName), ' fixture
 * @see \\', $modelClass, '
 */
class ', $fixtureName, ' extends ', $baseFixtureName, '
{

    public $modelClass = \'', $modelClass, '\';
';

/* @var $model pvsaintpe\boost\db\ActiveRecord */
$model = new $modelClass;

// depends/backDepends
$depends = [];
$backDepends = [];
foreach ($modelClass::allRelations() as $relationName => $relation) {
    if (isset($relation['viaTable']) && !$relation['viaTable']) {
        /* @var $relationClass string|pvsaintpe\boost\db\ActiveRecord */
        $relationClass = $model->getRelationClass($relationName);
        /* @var $relationFixtureClass string */
        $relationFixtureClass = $fixtureNs . '\\' . $relationClass::classShortName();
        if (($relationFixtureClass != $fixtureClass) && class_exists($relationFixtureClass)) {
            if ($relation['direct']) {
                $depends[] = $relationFixtureClass;
            } else {
                $backDepends[] = $relationFixtureClass;
            }
        }
    }
}
if (count($depends)) {
    echo '
    public $depends = ', Helper::implode($depends, 1), ';
';
}
if (count($backDepends)) {
    echo '
    public $backDepends = ', Helper::implode($backDepends, 1), ';
';
}

echo '
    /*[
';
/* @var $columns pvsaintpe\db\components\ColumnSchema[] */
$columns = array_values($tableSchema->columns);
foreach ($columns as $i => $column) {
    $comma = ($i < count($columns) - 1) ? ',' : '';
    echo '        \'', $column->name, '\' => \'\'', $comma, '
';
}
echo '    ]*/

    public $dataFile = \'', $dataFile, '\';
}
';
