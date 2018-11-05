<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class EventsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function testBasics()
    {
        $object = new class {

            use \BearFramework\App\EventsTrait;
        };

        $result = '';

        $listener1 = function() use (&$result) {
            $result .= '1';
        };
        $listener2 = function() use (&$result) {
            $result .= '2';
        };

        $object->addEventListener('done', $listener1);
        $object->addEventListener('done', $listener2);

        $this->assertTrue($result === '');

        $object->dispatchEvent(new \BearFramework\App\Event('other'));
        $this->assertTrue($result === '');

        $object->dispatchEvent(new \BearFramework\App\Event('done'));
        $this->assertTrue($result === '12');

        $object->removeEventListener('done', $listener1);
        $this->assertTrue($result === '12');
        $object->dispatchEvent(new \BearFramework\App\Event('done'));
        $this->assertTrue($result === '122');

        $object->removeEventListener('done', $listener1);
        $this->assertTrue($result === '122');
        $object->dispatchEvent(new \BearFramework\App\Event('done'));
        $this->assertTrue($result === '1222');

        $object->removeEventListener('done', $listener2);
        $this->assertTrue($result === '1222');
        $object->dispatchEvent(new \BearFramework\App\Event('done'));
        $this->assertTrue($result === '1222');
    }

    /**
     * 
     */
    function testEventArgument()
    {
        $object = new class {

            use \BearFramework\App\EventsTrait;
        };

        $result = '';

        $object->addEventListener('done', function(\BearFramework\App\Event $event) use (&$result) {
            $result .= $event->getName();
        });
        $object->dispatchEvent(new \BearFramework\App\Event('done'));

        $this->assertTrue($result === 'done');
    }

    /**
     * 
     */
    function testHasEventListeners()
    {
        $object = new class {

            use \BearFramework\App\EventsTrait;
        };

        $result = [
            'event1Dispached' => 0,
            'event1Handled' => 0,
            'event2Dispached' => 0,
        ];

        $object->addEventListener('event1', function(\BearFramework\App\Event $event) use (&$result) {
            $result['event1Handled'] = 1;
        });
        if ($object->hasEventListeners('event1')) {
            $result['event1Dispached'] = 1;
            $object->dispatchEvent(new \BearFramework\App\Event('event1'));
        }
        if ($object->hasEventListeners('event2')) {
            $result['event2Dispached'] = 1;
            $object->dispatchEvent(new \BearFramework\App\Event('event2'));
        }

        $this->assertEquals($result['event1Dispached'], 1);
        $this->assertEquals($result['event1Handled'], 1);
        $this->assertEquals($result['event2Dispached'], 0);
    }

    /**
     * 
     */
    function testCustomData()
    {
        $object = new class {

            use \BearFramework\App\EventsTrait;
        };

        $event = new class extends \BearFramework\App\Event {

            public $value = '1';

            public function __construct()
            {
                parent::__construct('done');
            }
        };

        $result = '';

        $object->addEventListener('done', function(\BearFramework\App\Event $event) use (&$result) {
            $result .= $event->getName() . '-' . $event->value;
        });
        $object->dispatchEvent($event);

        $this->assertTrue($result === 'done-1');
    }

}
