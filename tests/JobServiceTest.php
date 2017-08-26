<?php

namespace Dbseller\Tests;

use Dbseller\Service\JobService;

class JobServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testFormatIncorrectTime()
    {
        $jobService =  new JobService();

        $this->assertFalse($jobService->validateFormatTime('a * * * *'));
    }

    public function testFormatCorrectTime()
    {
        $jobService =  new JobService();

        $this->assertTrue($jobService->validateFormatTime('* * * * *'));
    }
}
