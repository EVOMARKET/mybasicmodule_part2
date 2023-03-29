<?php

class CommentTest extends ObjectModel
{
    public $id;
    public $user_id;
    public$comment;

    public static $definition = [
        'table'=>  'testcomment',
        'primary'=> 'id_sample',
        'multilang' => false,
        'multilang_shop'=>true,
        'fields'=>
        [
            'user_id'=>[
                'type'=>self::TYPE_STRING,
                'size'=>255,
               // 'validate'=>'isunsignedInt',
               'validate'=>'isCleanHtml',
                'required'=> true
            ],
            'comment'=> [
                'type'=>self::TYPE_STRING,
                'size'=>255,
                'validate'=>'isCleanHtml',
                'required'=>true
            ]
        ]
            ];
            
}