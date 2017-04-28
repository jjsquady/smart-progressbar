<?php
/**
 * Created by PhpStorm.
 * User: rodri
 * Date: 28/04/2017
 * Time: 12:52
 */

namespace Utils;


class ProgressBarTest extends \PHPUnit_Framework_TestCase
{

    public function test_if_is_instanciable()
    {
        $this->assertInstanceOf(ProgressBar::class, ProgressBar::init(0));
    }
    
    public function test_if_throws_maxvalue_exception()
    {
        $this->expectException(\Exception::class);
        
        ProgressBar::init('0');
    }

    public function test_if_increments_by_10()
    {
        $progbar = ProgressBar::init(20)->increments(10);

        $this->assertEquals(10, $progbar->getCurrentValue());
    }

    public function test_if_gets_progress_percentage()
    {
        $progbar = ProgressBar::init(20)->update(10);

        $this->assertEquals(50, $progbar->getProgressPercentage());
    }

    public function test_if_get_current_value()
    {
        $progbar = ProgressBar::init(20)->update(20);

        $this->assertEquals(20, $progbar->getCurrentValue());
    }

    public function test_if_get_max_value()
    {
        $progbar = ProgressBar::init(20)->update(20);

        $this->assertEquals(20, $progbar->getMaxValue());
    }
    
    public function test_if_render()
    {
        $progbar = ProgressBar::init(20)->update(10);

        $this->assertContains("[===============>", $progbar->render());

        $this->assertContains("remaining", $progbar->render());
    }

    public function test_if_locatization_render()
    {
        $progbar = ProgressBar::init(20)->localization(['remaining' => 'Tempo restante'])->update(10);

        $this->assertContains("Tempo restante", $progbar->render());
    }
}
