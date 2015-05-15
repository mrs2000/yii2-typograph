<?
namespace mrssoft\typograph;

/**
 * http://www.typograf.ru/
 * @package mrssoft\typograph
 */
class TypografRU implements TypographBase
{
    public function process($text)
    {
        $text = trim($text);
        if (empty($text)) {
            return '';
        }

        $ch = curl_init('http://www.typograf.ru/webservice/');

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_PROXY => false,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'text' => $text,
                'chr' => 'UTF-8'
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