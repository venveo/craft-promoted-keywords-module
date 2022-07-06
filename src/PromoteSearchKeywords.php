<?php
namespace modules\promotesearchkeywords;

use Craft;
use craft\elements\Entry;
use craft\events\DefineBehaviorsEvent;
use craft\events\RegisterElementSearchableAttributesEvent;
use modules\promotesearchkeywords\behaviors\PromotedSearchKeywords;
use yii\base\Event;
use yii\base\Module;

/**
 * Class PromoteSearchKeywords
 *
 * @package   PromoteSearchKeywords
 * @since     1.0.0
 *
 */
class PromoteSearchKeywords extends Module
{


    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/promotedsearchkeywords', $this->getBasePath());

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Event::on(Entry::class, Entry::EVENT_DEFINE_BEHAVIORS,
            function(DefineBehaviorsEvent $event) {
                $event->behaviors[] = PromotedSearchKeywords::class;
            }
        );

        Event::on(Entry::class, Entry::EVENT_REGISTER_SEARCHABLE_ATTRIBUTES, function(RegisterElementSearchableAttributesEvent $e) {
            $e->attributes[] = 'promotedSearchKeywords';
        });

    }
}
