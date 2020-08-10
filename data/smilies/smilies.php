<?php
defined('ByCCYNet') or exit('Access Invalid!');
$smilies_array                 = [];
$smilies_array['searcharray']  = [1  => '/' . preg_quote(htmlspecialchars(":smile:"), '/') . '/',
                                  2  => '/' . preg_quote(htmlspecialchars(":sad:"), '/') . '/',
                                  3  => '/' . preg_quote(htmlspecialchars(":biggrin:"), '/') . '/',
                                  4  => '/' . preg_quote(htmlspecialchars(":cry:"), '/') . '/',
                                  5  => '/' . preg_quote(htmlspecialchars(":huffy:"), '/') . '/',
                                  6  => '/' . preg_quote(htmlspecialchars(":shocked:"), '/') . '/',
                                  7  => '/' . preg_quote(htmlspecialchars(":tongue:"), '/') . '/',
                                  8  => '/' . preg_quote(htmlspecialchars(":shy:"), '/') . '/',
                                  9  => '/' . preg_quote(htmlspecialchars(":titter:"), '/') . '/',
                                  10 => '/' . preg_quote(htmlspecialchars(":sweat:"), '/') . '/',
                                  11 => '/' . preg_quote(htmlspecialchars(":mad:"), '/') . '/',
                                  12 => '/' . preg_quote(htmlspecialchars(":lol:"), '/') . '/',
                                  13 => '/' . preg_quote(htmlspecialchars(":loveliness:"), '/') . '/',
                                  14 => '/' . preg_quote(htmlspecialchars(":funk:"), '/') . '/',
                                  15 => '/' . preg_quote(htmlspecialchars(":curse:"), '/') . '/',
                                  16 => '/' . preg_quote(htmlspecialchars(":dizzy:"), '/') . '/',
                                  17 => '/' . preg_quote(htmlspecialchars(":shutup:"), '/') . '/',
                                  18 => '/' . preg_quote(htmlspecialchars(":sleepy:"), '/') . '/',
                                  19 => '/' . preg_quote(htmlspecialchars(":hug:"), '/') . '/',
                                  20 => '/' . preg_quote(htmlspecialchars(":victory:"), '/') . '/',
                                  21 => '/' . preg_quote(htmlspecialchars(":sun:"), '/') . '/',
                                  22 => '/' . preg_quote(htmlspecialchars(":moon:"), '/') . '/',
                                  23 => '/' . preg_quote(htmlspecialchars(":kiss:"), '/') . '/',
                                  24 => '/' . preg_quote(htmlspecialchars(":handshake:"), '/') . '/'
];
$smilies_array['replacearray'] = [1  => ['imagename' => 'smile.gif', 'desc' => '微笑'],
                                  2  => ['imagename' => 'sad.gif', 'desc' => '难过'],
                                  3  => ['imagename' => 'biggrin.gif', 'desc' => '呲牙'],
                                  4  => ['imagename' => 'cry.gif', 'desc' => '大哭'],
                                  5  => ['imagename' => 'huffy.gif', 'desc' => '发怒'],
                                  6  => ['imagename' => 'shocked.gif', 'desc' => '惊讶'],
                                  7  => ['imagename' => 'tongue.gif', 'desc' => '调皮'],
                                  8  => ['imagename' => 'shy.gif', 'desc' => '害羞'],
                                  9  => ['imagename' => 'titter.gif', 'desc' => '偷笑'],
                                  10 => ['imagename' => 'sweat.gif', 'desc' => '流汗'],
                                  11 => ['imagename' => 'mad.gif', 'desc' => '抓狂'],
                                  12 => ['imagename' => 'lol.gif', 'desc' => '阴险'],
                                  13 => ['imagename' => 'loveliness.gif', 'desc' => '可爱'],
                                  14 => ['imagename' => 'funk.gif', 'desc' => '惊恐'],
                                  15 => ['imagename' => 'curse.gif', 'desc' => '咒骂'],
                                  16 => ['imagename' => 'dizzy.gif', 'desc' => '晕'],
                                  17 => ['imagename' => 'shutup.gif', 'desc' => '闭嘴'],
                                  18 => ['imagename' => 'sleepy.gif', 'desc' => '睡'],
                                  19 => ['imagename' => 'hug.gif', 'desc' => '拥抱'],
                                  20 => ['imagename' => 'victory.gif', 'desc' => '胜利'],
                                  21 => ['imagename' => 'sun.gif', 'desc' => '太阳'],
                                  22 => ['imagename' => 'moon.gif', 'desc' => '月亮'],
                                  23 => ['imagename' => 'kiss.gif', 'desc' => '示爱'],
                                  24 => ['imagename' => 'handshake.gif', 'desc' => '握手']
];