<?php

namespace Spatie\Backup\Test\Unit;

use PHPUnit\Framework\TestCase;
use Spatie\Backup\Test\TestHelper;
use Spatie\Backup\Tasks\Backup\Zip;

class ZipTest extends TestCase
{
    /** @var \Spatie\Backup\Test\TestHelper */
    protected $testHelper;

    /** @var string */
    protected $pathToZip;

    /** @var \Spatie\Backup\Tasks\Backup\Zip */
    protected $zip;

    public function setUp()
    {
        parent::setUp();

        $this->testHelper = new TestHelper();

        $this->testHelper->initializeTempDirectory();

        $this->pathToZip = "{$this->testHelper->getTempDirectory()}/test.zip";

        $this->zip = new Zip($this->pathToZip);
    }

    /** @test */
    public function it_can_create_a_zip_file()
    {
        $this->zip->add(__FILE__);
        $this->zip->close();

        $this->assertFileExists($this->pathToZip);
    }

    /** @test */
    public function it_can_report_its_own_size()
    {
        $this->assertEquals(0, $this->zip->size());

        $this->zip->add(__FILE__);
        $this->zip->close();

        $this->assertNotEquals(0, $this->zip->size());
    }


    /** @test */
    public function it_can_determine_name_of_file_in_zip()
    {
        $this->assertEquals(
            '/Users/jon.doe/Documents/GitHub/laravel-backup/tests/temp/.gitignore',
            $this->testHelper->callMethod(
                $this->zip,
                'determineNameOfFileInZip',
                array(
                    'C:\Users\jon.doe\Documents\GitHub\laravel-backup\tests/temp\.gitignore',
                    'C:\Users\jon.doe\Documents\GitHub\laravel-backup\vendor\orchestra\testbench-core\src\Concerns/../../laravel\storage\app/backup-temp\temp\2016-01-01-21-01-01.zip'
                )
            )
        );
    }
}
