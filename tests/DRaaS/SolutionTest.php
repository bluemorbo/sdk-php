<?php

namespace Tests\DRaaS;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SolutionTest extends TestCase
{
    /**
     * @test
     */
    public function get_solutions()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    [
                        'id' => 'dc76dbbb-12a6-11ea-89fb-005056a64a16',
                        'reseller_id' => 1,
                        'name' => 'Clifford Home',
                        'tenant_uid' => '4333f8f4-2d47-4856-b5f1-74af0dcab3cd'
                    ],
                    [
                        'id' => 'fae31760-3c6e-11ea-89fb-005056a64a16',
                        'reseller_id' => 2,
                        'name' => 'Paul',
                        'tenant_uid' => 'e76c005e-a8ab-4039-a438-fd13e3621988'
                    ],
                ],
                "meta" => [
                    "pagination" => [
                        "total" => 2,
                        "count" => 2,
                        "per_page" => 100,
                        "current_page" => 1,
                        "total_pages" => 1,
                        "links" => []
                    ]
                ]
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new \UKFast\SDK\DRaaS\Client($guzzle);

        $page = $client->solutions()->getPage();

        $this->assertTrue($page instanceof \UKFast\SDK\Page);
        $request = $page->getItems()[0];

        $this->assertTrue($request instanceof \UKFast\SDK\DRaaS\Entities\Solution);

        $this->assertEquals('dc76dbbb-12a6-11ea-89fb-005056a64a16', $request->id);
        $this->assertEquals(1, $request->resellerId);
        $this->assertEquals('Clifford Home', $request->name);
        $this->assertEquals('4333f8f4-2d47-4856-b5f1-74af0dcab3cd', $request->tenantUid);
    }

    /**
     * @test
     */
    public function get_solution()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'data' => [
                    'id' => 'dc76dbbb-12a6-11ea-89fb-005056a64a16',
                    'reseller_id' => 1,
                    'name' => 'Clifford Home',
                    'tenant_uid' => '4333f8f4-2d47-4856-b5f1-74af0dcab3cd'
                ],
                "meta" => []
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzle = new Guzzle(['handler' => $handler]);
        $client = new \UKFast\SDK\DRaaS\Client($guzzle);
        $solution = $client->solutions()->getById('dc76dbbb-12a6-11ea-89fb-005056a64a16');

        $this->assertTrue($solution instanceof \UKFast\SDK\DRaaS\Entities\Solution);

        $this->assertEquals('dc76dbbb-12a6-11ea-89fb-005056a64a16', $solution->id);
        $this->assertEquals(1, $solution->resellerId);
        $this->assertEquals('Clifford Home', $solution->name);
        $this->assertEquals('4333f8f4-2d47-4856-b5f1-74af0dcab3cd', $solution->tenantUid);
    }
}
