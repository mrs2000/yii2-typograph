<?
namespace mrssoft\typograph;

/**
 * http://rmcreative.ru/blog/post/tipograf
 * @package mrssoft\typograph
 */
class RMCreative implements TypographBase
{
    public function process($text)
    {
        include_once(__DIR__.'/typographus.php');
        $typographus = new \Typographus('UTF-8');
        $typographus->setOpt(\Typographus::HTML_ENTITIES, false);
        return $typographus->process($text);
    }
}