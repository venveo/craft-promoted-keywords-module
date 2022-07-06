<?php

namespace modules\promotesearchkeywords\behaviors;

use craft\db\Query;
use craft\db\Table;
use craft\elements\Asset;
use craft\elements\Entry;
use craft\elements\MatrixBlock;
use craft\helpers\ArrayHelper;
use craft\web\Session;
use modules\promotesearchkeywords\PromoteSearchKeywords;
use yii\base\Behavior;

class PromotedSearchKeywords extends Behavior
{
    /**
     * @return string|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getPromotedSearchKeywords()
    {
        /** @var Entry $entry */
        $entry = $this->owner;
        if ($entry->section->handle !== 'pages') {
            return '';
        }
        $blockIds = MatrixBlock::find()->owner($entry)->ids();
        $blockIds = array_merge($blockIds, [$entry->id]);
        $relatedEntries = Entry::find()->relatedTo($blockIds)->ids();
        $results = (new Query())
            ->select(['elementId', 'keywords'])
            ->from([Table::SEARCHINDEX])
            ->where(
                ['in', 'elementId', $relatedEntries]
            )->all();
        $keywords = implode(' ', ArrayHelper::getColumn($results, 'keywords'));
        return $keywords;
    }
}