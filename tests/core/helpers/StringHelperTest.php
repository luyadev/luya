<?php

namespace luyatests\core\helpers;

use luya\helpers\StringHelper;
use luyatests\LuyaWebTestCase;

class StringHelperTest extends LuyaWebTestCase
{
    public function testStringTypeCast()
    {
        $this->assertSame(0, StringHelper::typeCast("0"));
        $this->assertSame(1, StringHelper::typeCast('1'));
        $this->assertSame('string', StringHelper::typeCast('string'));
        $this->assertSame([1=>'bar'], StringHelper::typeCast(['1' => 'bar']));
    }
    
    public function testReplaceFirst()
    {
        $this->assertSame('abc 123 123', StringHelper::replaceFirst('123', 'abc', '123 123 123'));
        $this->assertSame('abc 123 ABC', StringHelper::replaceFirst('ABC', '123', 'abc ABC ABC'));
    }

    public function testIsFloat()
    {
        $this->assertTrue(StringHelper::isFloat('1.0'));
        $this->assertTrue(StringHelper::isFloat("1.0"));
        $this->assertTrue(StringHelper::isFloat(1.0));
        $this->assertTrue(StringHelper::isFloat(1));
        $this->assertTrue(StringHelper::isFloat('1'));
        $this->assertTrue(StringHelper::isFloat('-1'));
        $float = 1.0;
        $this->assertTrue(StringHelper::isFloat($float));
        
        $this->assertFalse(StringHelper::isFloat('string'));
    }
    
    public function testTypeCastNumeric()
    {
        $this->assertSame(1, StringHelper::typeCastNumeric('1'));
        $this->assertSame(1.5, StringHelper::typeCastNumeric('1.5'));
        $this->assertSame(-1, StringHelper::typeCastNumeric('-1'));
        $this->assertSame(-1.5, StringHelper::typeCastNumeric('-1.5'));
        
        $this->assertSame(1, StringHelper::typeCastNumeric(1));
        $this->assertSame(1.5, StringHelper::typeCastNumeric(1.5));
        $this->assertSame(-1, StringHelper::typeCastNumeric(-1));
        $this->assertSame(-1.5, StringHelper::typeCastNumeric(-1.5));
        
        $this->assertSame(1, StringHelper::typeCastNumeric(true));
        $this->assertSame(0, StringHelper::typeCastNumeric(false));
        $this->assertSame('string', StringHelper::typeCastNumeric('string'));
        $this->assertSame([], StringHelper::typeCastNumeric([]));
    }
    
    public function testContains()
    {
        $this->assertTrue(StringHelper::contains('z', 'abzef'));
        $this->assertTrue(StringHelper::contains('1', 'test1'));
        $this->assertFalse(StringHelper::contains('B', 'abc'));
        $this->assertFalse(StringHelper::contains('@', 'nomail'));
        $this->assertTrue(StringHelper::contains('@', 'joh@doe.com'));
        $this->assertTrue(StringHelper::contains('.', 'john@doe.com'));
        $this->assertTrue(StringHelper::contains('word', 'thewordexists'));
        $this->assertFalse(StringHelper::contains('word', 'theWORDexists'));
        $this->assertfalse(StringHelper::contains('no', 'theword'));
    }
    
    public function testArrayContains()
    {
        $this->assertTrue(StringHelper::contains(['foo', 'bar'], 'hello foo bar')); // disabled $strict mode
        $this->assertTrue(StringHelper::contains(['notexistings', 'bar'], 'hello bar foo')); // disabled $strict mode
        $this->assertTrue(StringHelper::contains(['bar', 'notexistings'], 'hello bar foo')); // disabled $strict mode
        $this->assertFalse(StringHelper::contains(['notexistings'], 'hello bar foo'));
    }

    public function testArrayStrictContains()
    {
        $this->assertTrue(StringHelper::contains(['foo', 'bar'], 'hello foo bar', true)); // enabled $strict mode
        $this->assertFalse(StringHelper::contains(['notexistings', 'bar'], 'hello bar foo', true)); // enabled $strict mode
        $this->assertFalse(StringHelper::contains(['bar', 'notexistings'], 'hello bar foo', true)); // enabled $strict mode
        $this->assertFalse(StringHelper::contains(['notexistings'], 'hello bar foo', true)); // enabled strict mode
        $this->assertTrue(StringHelper::contains(['a', 'b', 'c'], 'thesmallabc', true));
    }
    
    public function testStartsWithWildcard()
    {
        $this->assertFalse(StringHelper::startsWithWildcard('abcdefgh', 'abc'));
        $this->assertTrue(StringHelper::startsWithWildcard('abcdefgh', 'abc*'));
        $this->assertFalse(StringHelper::startsWithWildcard('ABCDEFGHI', 'abc*'));
        $this->assertTrue(StringHelper::startsWithWildcard('ABCDEFGHI', 'abc*', false));
    }
    
    public function testMinify()
    {
        $this->assertSame('foo bar', StringHelper::minify('    foo       bar     '));
        $content = <<<EOT
    foo
    
bar
EOT;
        $this->assertSame('foo bar', StringHelper::minify($content));
        $html = <<<EOT
<html>
    <head>
        <title>foobar</title>
        <script>
            function alert = function(msg) {
                console.log(msg);
            };
        </script>
    </head>
    <body>
        <p>foo bar</p>  <p>bar foo</p> <p>qux</p>
    </body>
</html>
EOT;
        
        $this->assertSame('<html><head><title>foobar</title><script> function alert = function(msg) { console.log(msg); }; </script></head><body><p>foo bar</p><p>bar foo</p><p>qux</p></body></html>', StringHelper::minify($html));
    
        $comment = <<<EOT
<div>
    <p>foo bar</p>
    <!-- foo bar end is near! -->
</div>
EOT;
        $this->assertSame('<div><p>foo bar</p></div>', StringHelper::minify($comment, ['comments' => true]));
    }

    public function testCut()
    {
        $this->assertSame('foo abc bar', StringHelper::truncateMiddle('foo abc bar', 'abc', 4));
        $this->assertSame('..o abc b..', StringHelper::truncateMiddle('foo abc bar', 'abc', 2));
        $this->assertSame('foo abc bar..', StringHelper::truncateMiddle('foo abc barbazquax', 'abc', 4));
        $this->assertSame('..uax abc bar', StringHelper::truncateMiddle('barbazquax abc bar', 'abc', 4));
        $this->assertSame('..e quick fox jumped over the la..', StringHelper::truncateMiddle('the quick fox jumped over the lazy dog', 'jumped', 12));
        $this->assertSame('..нный путь влечет за собой процесс внедрения и..', StringHelper::truncateMiddle('Не следует, однако, забывать, что высокое качество позиционных исследований выявляет срочную потребность анализа существующих паттернов поведения. Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: экономическая повестка сегодняшнего дня в значительной степени обусловливает важность первоочередных требований. Равным образом, реализация намеченных плановых заданий обеспечивает актуальность системы массового участия. Следует отметить, что выбранный нами инновационный путь влечет за собой процесс внедрения и модернизации первоочередных требований. Сложно сказать, почему сделанные на базе интернет-аналитики выводы призваны к ответу. Но дальнейшее развитие различных форм деятельности создает необходимость включения в производственный план целого ряда внеочередных мероприятий с учетом комплекса как самодостаточных, так и внешне зависимых концептуальных решений. Как уже неоднократно упомянуто, акционеры крупнейших компаний, которые представляют собой яркий пример континентально-европейского типа политической культуры, будут преданы социально-демократической анафеме. Ясность нашей позиции очевидна: перспективное планирование, в своем классическом представлении, допускает внедрение поставленных обществом задач. Учитывая ключевые сценарии поведения, существующая теория однозначно определяет каждого участника как способного принимать собственные решения касаемо кластеризации усилий. Имеется спорная точка зрения, гласящая примерно следующее: базовые сценарии поведения пользователей, превозмогая сложившуюся непростую экономическую ситуацию, смешаны с неуникальными данными до степени совершенной неузнаваемости, из-за чего возрастает их статус бесполезности. Приятно, граждане, наблюдать, как базовые сценарии поведения пользователей будут призваны к ответу.', 'собой', 20));
        $this->assertSame('..oo abc ba..', StringHelper::truncateMiddle('foo abc bar', 'ABC', 3));
        $this->assertSame('..oo ABC ba..', StringHelper::truncateMiddle('foo ABC bar', 'abc', 3));
        $this->assertSame('foo abc..', StringHelper::truncateMiddle('foo abc bar', 'notfound', 4));
    }

    public function testHighlightWord()
    {
        $this->assertSame('foo <b>bar</b> foo', StringHelper::highlightWord('foo bar foo', 'bar'));
        $this->assertSame('foo <b>1</b> foo', StringHelper::highlightWord('foo 1 foo', '1'));
        $this->assertSame('<b>foo</b> bar <b>foo</b>', StringHelper::highlightWord('foo bar foo', 'foo'));
        $this->assertSame('Не следует, <b>однако</b>, забывать', StringHelper::highlightWord('Не следует, однако, забывать', 'однако'));

        $str = 'Durch unsere kompetenten und motivierten Mitarbeitenden ist eine bedarfsgerechte Betreuung und Pflege stets gewährleistet.
        Neben verschiedenen Veranstaltungen, die im Blumenrain stattfinden, wird ein wöchentliches Aktivierungsprogramm vor Ort angeboten.';
        $this->assertContains('<b>bedarf</b>sgerechte', StringHelper::highlightWord($str, 'bedarf'));

        $this->assertContains(' unsere <b>kompetent</b>en und <b>motiviert</b>en', StringHelper::highlightWord($str, ['kompetent', 'motiviert']));

        $this->assertContains(' unsere <b>kompetent</b>en und <b>motiviert</b>en', StringHelper::highlightWord($str, ['Kompetent', 'Motiviert']));
        $this->assertContains('vor <b>Ort</b> angebot', StringHelper::highlightWord($str, 'ort'));
    }

    public function testCutAndHighlightWord()
    {
        $word = 'John';
        $this->assertSame('..in lustiger Satz mit dem Word <b>John</b> mit Doe und Jane Doe.', StringHelper::highlightWord(StringHelper::truncateMiddle('Das ist ein lustiger Satz mit dem Word John mit Doe und Jane Doe.', $word, 30), $word));
        $word = 'забывать'; // Приятно
        $text = StringHelper::truncateMiddle('Не следует, однако, забывать, что высокое ка', $word, 20);
        $this->assertSame('Не следует, однако, забывать, что высокое ка', $text);
        $this->assertSame('Не следует, однако, <b>забывать</b>, что высокое ка', StringHelper::highlightWord($text, $word));
    }

    public function testIsNumeric()
    {
        $this->assertTrue(StringHelper::isNummeric(1));
        $this->assertTrue(StringHelper::isNummeric(1, false));
        $this->assertTrue(StringHelper::isNummeric(112334));
        $this->assertTrue(StringHelper::isNummeric(112334, false));

        // mixed char
        $this->assertFalse(StringHelper::isNummeric('abc'));
        $this->assertFalse(StringHelper::isNummeric('xyz2'));
        $this->assertFalse(StringHelper::isNummeric('abc', false));
        $this->assertFalse(StringHelper::isNummeric('xyz2', false));

        // none scalar
        $this->assertFalse(StringHelper::isNummeric(true));
        $this->assertFalse(StringHelper::isNummeric(true, false));
        $this->assertFalse(StringHelper::isNummeric(false));
        $this->assertFalse(StringHelper::isNummeric(false, false));
        $this->assertFalse(StringHelper::isNummeric([]));
        $this->assertFalse(StringHelper::isNummeric([], false));
        
        
        // exponent number case
        $this->assertFalse(StringHelper::isNummeric('3e30'));
        $this->assertTrue(StringHelper::isNummeric('3e30', false));
    }

    public function testMbStrSplit()
    {
        $this->assertSame([
            'f','o','o', ' ', 'b', 'a', 'r'
        ], StringHelper::mb_str_split('foo bar'));
        $this->assertSame([
            'fo', 'o ', 'ba', 'r'
        ], StringHelper::mb_str_split('foo bar', 2));

        $this->assertSame([
            0 => 'М',
            1 => 'а',
            2 => 'р',
            3 => 'у',
            4 => 'с',
            5 => 'я',
        ], StringHelper::mb_str_split('Маруся'));
    }

    public function testMatchFilter()
    {
        $this->assertTrue(StringHelper::filterMatch('hello', 'hello'));
        $this->assertTrue(StringHelper::filterMatch('hello', 'HELLO'));
        $this->assertTrue(StringHelper::filterMatch('hello', 'he*'));
        $this->assertFalse(StringHelper::filterMatch('hello', ['foo', 'bar']));
        $this->assertFalse(StringHelper::filterMatch('hello', '!hello'));
        $this->assertFalse(StringHelper::filterMatch('hello', '!hello', 'hello'));
    }

    public function testTemplate()
    {
        $this->assertSame('<p>bar</p>', StringHelper::template('<p>bar</p>'));
        $this->assertSame('<p>bar</p>', StringHelper::template('<p>{{foo}}</p>', ['foo' => 'bar']));
        $this->assertSame('<p>bar</p>', StringHelper::template('<p>{{ foo }}</p>', ['foo' => 'bar']));

        $this->assertSame('<p>bar {{unknown}}</p>', StringHelper::template('<p>{{ foo }} {{unknown}}</p>', ['foo' => 'bar']));
        $this->assertSame('<p>bar {{unknown}}</p>', StringHelper::template('<p>{{ foo }} {{unknown}}</p>', ['foo' => 'bar', 'xyz' => 'abc']));
        $this->assertSame('<p>bar </p>', StringHelper::template('<p>{{ foo }} {{unknown}}</p>', ['foo' => 'bar', 'xyz' => 'abc'], true));
    }
}
