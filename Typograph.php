<?
namespace mrssoft\typograph;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * Typograph behavior
 * http://www.typograf.ru/
 */
class Typograph extends Behavior
{
    public $attributes = ['text'];

    public $service = 'http://www.typograf.ru/webservice/';

    public $encodind = 'UTF-8';

    public $preferences = [];

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

        foreach ($this->attributes as $attribute) {
            $this->owner{$attribute} = $this->typograph($this->owner{$attribute});
        }
    }

    private function typograph($text)
    {
        $text = trim($text);
        if (empty($text)) {
            return '';
        }

        $ch = curl_init($this->service);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_PROXY => false,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'text' => $text,
                'chr' => $this->encodind
            ]
        ]);

        $result = curl_exec($ch);
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200 || curl_errno($ch) || empty($result)) {
            \Yii::error('Typograph error: (' . curl_errno($ch) . ') ' . curl_error($ch). ', response: '.$result);
            $result = $text;
        }
        curl_close($ch);

        return $result;
    }
}