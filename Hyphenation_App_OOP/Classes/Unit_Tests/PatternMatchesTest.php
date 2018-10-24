<?php
/**
 * Created by PhpStorm.
 * User: norbertas
 * Date: 18.10.23
 * Time: 10.14
 */


require "PatternMatches.php";

use PHPUnit\Framework\TestCase;



class PatternMatchesTest extends TestCase
{

    public function testPatternMatches()
    {
        $testMatches = new PatternMatches();
        $patternArray = explode("\n", file_get_contents('/home/norbertas/PhpstormProjects/uzduotis1/Hyphenation_App_OOP/Resources/pattern_data.txt'));

        $result = $testMatches->getPatternMatches('mistranslate', $patternArray);
        $output = [


        ];

        $this->assertEquals($output, $result);
    }
}