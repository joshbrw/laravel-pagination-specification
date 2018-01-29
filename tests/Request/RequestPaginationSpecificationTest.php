<?php

namespace Joshbrw\PaginationSpecification\Tests;

use Illuminate\Http\Request;
use Joshbrw\PaginationSpecification\Request\RequestPaginationSpecification;
use PHPUnit\Framework\TestCase;

class RequestPaginationSpecificationTest extends TestCase
{

    /** @test */
    public function can_be_filled_from_request()
    {
        $request = new Request([
            'per_page' => 30,
            'page' => 5
        ]);

        $specification = $this->getSpecification();
        $specification->fromRequest($request);

        $this->assertSame(30, $specification->getPerPage());
        $this->assertSame(5, $specification->getCurrentPage());
    }

    /** @test */
    public function can_set_custom_page_name_and_read_from_request_using_that_name()
    {
        $specification = $this->getSpecification();
        $specification->setPageName('customPageName');

        $request = new Request([
            'per_page' => 10,
            'customPageName' => 4
        ]);

        $specification->fromRequest($request);

        $this->assertSame(4, $specification->getCurrentPage());
    }

    /** @test */
    public function it_should_default_to_page_one_if_no_page_set()
    {
        $specification = $this->getSpecification();

        $this->assertSame(1, $specification->getCurrentPage());
    }

    /** @test */
    public function can_set_per_page()
    {
        $specification = $this->getSpecification();

        $specification->setPerPage(150);

        $this->assertSame(150, $specification->getPerPage());
    }

    /** @test */
    public function can_set_current_page()
    {
        $specification = $this->getSpecification();

        $specification->setCurrentPage(32);

        $this->assertSame(32, $specification->getCurrentPage());
    }

    /** @test */
    public function can_add_single_apppend()
    {
        $specification = $this->getSpecification();

        $specification->addAppends('appendKey', 'appendValue');

        $this->assertSame(['appendKey' => 'appendValue'], $specification->getAppends());
    }

    /** @test */
    public function can_add_array_of_appends()
    {
        $specification = $this->getSpecification();

        $specification->addAppends($appends = [
            'appendOne' => 'something',
            'appendTwo' => 'somethingElse'
        ]);

        $this->assertSame($appends, $specification->getAppends());
    }

    /** @test */
    public function adding_appends_should_merge_with_existing()
    {
        $specification = $this->getSpecification();

        $specification->addAppends([
            'appendOne' => 'valueOne',
            'appendTwo' => 'valueTwo'
        ]);

        $specification->addAppends('appendThree', 'valueThree');

        $specification->addAppends([
            'appendFour' => 'valueFour',
            'appendFive' => 'valueFive'
        ]);

        $this->assertSame([
            'appendOne' => 'valueOne',
            'appendTwo' => 'valueTwo',
            'appendThree' => 'valueThree',
            'appendFour' => 'valueFour',
            'appendFive' => 'valueFive',
        ], $specification->getAppends());
    }

    /** @test */
    public function the_appends_should_contain_the_per_page_by_default()
    {
        $specification = $this->getSpecification();

        $specification->setPerPage(10);

        $this->assertSame([
            'per_page' => 10
        ], $specification->getAppends());
    }

    /** @test */
    public function the_appends_should_contain_the_per_page_when_other_appends_provided()
    {
        $specification = $this->getSpecification();

        $specification->addAppends('appendOne', 'valueOne');
        $specification->addAppends([
            'appendTwo' => 'valueTwo',
            'appendThree' => 'valueThree'
        ]);

        $specification->setPerPage(15);

        $this->assertSame([
            'per_page' => 15,
            'appendOne' => 'valueOne',
            'appendTwo' => 'valueTwo',
            'appendThree' => 'valueThree',
        ], $specification->getAppends());
    }

    /** @test */
    public function adding_append_with_same_key_as_existing_should_overwrite()
    {
        $specification = $this->getSpecification();

        $specification->addAppends([
            'keyOne' => 'valueOne',
            'keyTwo' => 'valueTwo'
        ]);

        $specification->addAppends('keyOne', 'newValueOne');
        $specification->addAppends([
            'keyTwo' => 'newValueTwo'
        ]);

        $this->assertSame([
            'keyOne' => 'newValueOne',
            'keyTwo' => 'newValueTwo',
        ], $specification->getAppends());
    }

    protected function getSpecification(): RequestPaginationSpecification
    {
        return new RequestPaginationSpecification;
    }
}
