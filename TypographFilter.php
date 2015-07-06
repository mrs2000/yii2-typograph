<?
namespace mrssoft\typograph;

use yii\validators\Validator;

/**
 * Typograph filter
 */
class TypographFilter extends Validator
{
    public $method = '\mrssoft\typograph\Mdash';

    public $skipOnError = true;

    public $skipOnEmpty = true;

    public $enableClientValidation = false;

    /**
     * @var TypographBase
     */
    private $typographCore;

    public function init()
    {
        $this->typographCore = new $this->method();
    }

    public function validateAttribute($object, $attribute)
    {
        $object->{$attribute} = $this->typographCore->process($object->{$attribute});
    }
}