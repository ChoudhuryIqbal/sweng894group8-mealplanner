<?php
namespace Base\Test;

require_once __DIR__.'/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
// Add the classes you are testing
use Base\Models\Unit;


class UnitTest extends TestCase {
    // Variables to be reused
    private $unit;


    /**
     * Create instances or whatever you need to reuse in several tests here
     */
    public function setUp(){
        $this->unit = new Unit();
    }

    /**
     * Unset any variables you've created
     */
    public function tearDown(){
      unset($this->unit);
    }

    public function testCreateUnit(){

    	$this->assertInstanceOf(
            'Base\Models\Unit',
            new Unit(),
            'Object must be instance of Unit');
    }

    ////////
    // Id //
    ////////
    public function testSetAndGetId(){
        $id = 1;
        $this->unit->setId($id);
        $this->assertEquals($this->unit->getId(), $id);
    }

    public function testIdCannotBeEmpty(){
        $this->expectException(\Exception::class);
        $this->unit->setId(NULL);
    }

    public function testIdIsAnInteger(){
        $intId = 123;
        $this->unit->setId($intId);
        $this->assertInternalType('integer', $this->unit->getId());
    }

    public function testNonIntIdsAreRejected(){
        $nonIntId = '123';
        $this->expectException(\Exception::class);
        $this->unit->setId($nonIntId);
    }

    //////////
    // Name //
    //////////

    public function testSetAndGetName(){
        $this->unit->setName('mililiter(s)');
        $this->assertEquals($this->unit->getName(), 'mililiter(s)');
    }

    public function testNameCannotBeEmpty(){
        $this->expectException(\Exception::class);
        $this->unit->setName('');
    }

    public function testNameCannotBeLongerThan20Chars(){
        $longName = '123456789012345678901234567890';
        $this->expectException(\Exception::class);
        $this->unit->setName($longName);
    }

    public function testNameCannotHaveExtraWhitespace(){
        $nameWithWhitespace = '       mililiter(s)   ';
        $expectedName =  'mililiter(s)';
        $this->unit->setName($nameWithWhitespace);

        $this->assertEquals($this->unit->getName(), $expectedName,
            'Name must be trimmed.');
    }

    public function testNameMustOnlyContainLettersAndParentheses(){
        $invalidName = 'a bad name!';

        $this->expectException(\Exception::class);
        $this->unit->setName($invalidName);
    }

    //////////////////
    // Abbreviation //
    //////////////////
    public function testSetAndGetAbbreviation(){
        $this->unit->setAbbreviation('mL');
        $this->assertEquals($this->unit->getAbbreviation(), 'mL');
    }

    public function testAbbreviationCannotBeEmpty(){
        $this->expectException(\Exception::class);
        $this->unit->setAbbreviation('');
    }

    public function testAbbreviationCannotBeLongerThan4Chars(){
        $longAbbreviation = '12345';
        $this->expectException(\Exception::class);
        $this->unit->setAbbreviation($longAbbreviation);
    }

    public function testAbbreviationCannotHaveExtraWhitespace(){
        $abbreviationWithWhitespace = '       mL   ';
        $expectedAbbreviation =  'mL';
        $this->unit->setAbbreviation($abbreviationWithWhitespace);

        $this->assertEquals($this->unit->getAbbreviation(), $expectedAbbreviation,
            'Abbreviation must be trimmed.');
    }

    public function testAbbreviationMustBeAlphabetical(){
        $invalidAbbreviation = 'bad!';

        $this->expectException(\Exception::class);
        $this->unit->setAbbreviation($invalidAbbreviation);
    }

    ///////////////
    // Base Unit //
    ///////////////

    public function testSetAndGetBaseUnit(){
        $baseUnit = 'mL';
        $this->unit->setBaseUnit($baseUnit);
        $this->assertEquals($this->unit->getBaseUnit(), $baseUnit);
    }

    public function testBaseUnitCannotBeEmpty(){
        $this->expectException(\Exception::class);
        $this->unit->setBaseUnit('');
    }

    public function testBaseUnitCannotBeLongerThan4Chars(){
        $longBaseUnit = 'abcde';
        $this->expectException(\Exception::class);
        $this->unit->setBaseUnit($longBaseUnit);
    }

    public function testBaseUnitCannotHaveExtraWhitespace(){
        $nameWithWhitespace = ' mL ';
        $expectedBaseUnit =  'mL';
        $this->unit->setBaseUnit($nameWithWhitespace);

        $this->assertEquals($this->unit->getBaseUnit(), $expectedBaseUnit,
            'BaseUnit must be trimmed.');
    }

    public function testBaseUnitMustBeAlphabetical(){
        $invalidBaseUnit = 'm!';

        $this->expectException(\Exception::class);
        $this->unit->setBaseUnit($invalidBaseUnit);
    }


    //////////////
    // Base Eqv //
    //////////////

    public function testSetAndGetBaseEqv(){
        $baseEqv = 12345.12345678;
        $this->unit->setBaseEqv($baseEqv);
        $this->assertEquals($this->unit->getBaseEqv(), $baseEqv, '', 0.00000001);
    }

    public function testBaseEqvIsDouble(){
        $baseEqv = 12345.12345678;
        $this->unit->setBaseEqv($baseEqv);
        $this->assertInternalType('double', $this->unit->getBaseEqv());
    }

    public function testBaseEqvCannotBeNegative(){
        $negativeBaseEqv = -12345.6789;
        $this->expectException(\Exception::class);
        $this->unit->setBaseEqv($negativeBaseEqv);
    }

    public function testBaseEqvCannotBeZero(){
        $negativeBaseEqv = 0;
        $this->expectException(\Exception::class);
        $this->unit->setBaseEqv($negativeBaseEqv);
    }
    //
    // public function testBaseEqvCannotHaveExtraWhitespace(){
    //     $abbreviationWithWhitespace = '       mL   ';
    //     $expectedBaseEqv =  'mL';
    //     $this->unit->setBaseEqv($abbreviationWithWhitespace);
    //
    //     $this->assertEquals($this->unit->getBaseEqv(), $expectedAbbreviation,
    //         'Abbreviation must be trimmed.');
    // }
}
