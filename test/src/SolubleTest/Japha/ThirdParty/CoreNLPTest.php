<?php

/*
 * Soluble Japha
 *
 * @link      https://github.com/belgattitude/soluble-japha
 * @copyright Copyright (c) 2013-2017 Vanvelthem Sébastien
 * @license   MIT License https://github.com/belgattitude/soluble-japha/blob/master/LICENSE.md
 */

namespace SolubleTest\Japha\ThirdParty;

use Soluble\Japha\Bridge\Adapter;
use PHPUnit\Framework\TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-11-04 at 16:47:42.
 */
class CoreNLPTest extends TestCase
{
    /**
     * @var string
     */
    protected $servlet_address;

    /**
     * @var Adapter
     */
    protected $adapter;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        if (!$this->isCoreNLPTestsEnabled()) {
            $this->markTestSkipped(
                'Skipping CORENLP tests, enable option in phpunit.xml'
            );
        }

        \SolubleTestFactories::startJavaBridgeServer();

        $this->servlet_address = \SolubleTestFactories::getJavaBridgeServerAddress();

        $this->adapter = new Adapter([
            'driver' => 'Pjb62',
            'servlet_address' => $this->servlet_address,
        ]);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    protected function isCoreNLPTestsEnabled()
    {
        return isset($_SERVER['JAPHA_ENABLE_CORENLP_TESTS']) &&
            $_SERVER['JAPHA_ENABLE_CORENLP_TESTS'] == true;
    }

    /**
     * @see http://stanfordnlp.github.io/CoreNLP/simple.html
     */
    public function testSimple()
    {
        $ba = $this->adapter;
        $driver = $ba->getDriver();

        $text = 'add your text here! It can contain multiple sentences. Hello world.';

        $doc = $ba->java('edu.stanford.nlp.simple.Document', $text);

        $sentences = $doc->sentences();
        $results = [];

        foreach ($sentences as $idx => $sentence) {
            $results[$idx] = [
                'sentence' => (string) $sentence,
                'words' => $driver->values($sentence->words())
            ];
            // If you have a model installed, use lemmas(), posTags(), parse()... methods
            // $results[$idx]['posTags'] = $driver->values($sentence->posTags()->toArray())
            // $results[$idx]['parse'] = $driver->values($sentence->parse()->toArray())
            // $results[$idx]['lemmas'] = $driver->values($sentence->lemmas()->toArray()),
        }

        $this->assertEquals('add your text here!', $results[0]['sentence']);
        $this->assertEquals('Hello world.', $results[2]['sentence']);
        $this->assertEquals('Hello', $results[2]['words'][0]);
    }
}
