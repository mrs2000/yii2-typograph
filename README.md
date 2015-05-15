# yii2-typograph

Usage as filter:

```php
public function rules()
{
    return [
    	['text', '\mrssoft\typograph\TypographFilter'],
    ]
}
```

Usage as behavior:

```php
public function behaviors()
{
 	return [
 		'typograph' => [
 			'class' => \mrssoft\typograph\TypographFilter::className(),
 			'attributes' => ['text'],
        ]
 	];
}
```
