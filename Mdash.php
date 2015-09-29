<?
namespace mrssoft\typograph;

/**
 * http://mdash.ru/
 * @package mrssoft\typograph
 */
class MDash implements TypographBase
{
    public function process($text)
    {
        $text = trim($text);
        if (empty($text)) {
            return '';
        }

        $ch = curl_init('http://mdash.ru/api.v1.php');

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_PROXY => false,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'text' => $text,
                'Text.paragraphs' => 'off',
                'Text.breakline' => 'off',
                'OptAlign.all' => 'off',
                'Etc.unicode_convert' => 'off',
                'Nobr.spaces_nobr_in_surname_abbr' => 'off',
				'Etc.split_number_to_triads' => 'off'
            ]
        ]);

        $result = curl_exec($ch);
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200 || curl_errno($ch) || empty($result)) {
            \Yii::warning('Typograph error: (' . curl_errno($ch) . ') ' . curl_error($ch) . ', response: ' . $result);
            $result = $text;
        }
        curl_close($ch);

        $result = json_decode($result, true);
        if (!is_array($result) || !isset($result['result'])) {
            $result = $text;
        } else {
            $result = $result['result'];
        }

        return $result;
    }
}