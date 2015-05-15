<?
namespace mrssoft\typograph;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * Typograph behavior
 */
class TypographBehavior extends Behavior
{
    public $attributes = ['text'];

    public $method = '\mrssoft\typograph\TypografRU';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    public function beforeSave()
    {
        if (empty($this->attributes)) {
            throw new InvalidConfigException('Attributes is empty.');
        }

        if (!is_array($this->attributes)) $this->attributes = [$this->attributes];

        /** @var $typographCore TypographBase */
        $typographCore = new $this->method();

        foreach ($this->attributes as $attribute) {
            $this->owner{$attribute} = $typographCore->process($this->owner{$attribute});
        }
    }
}