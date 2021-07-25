<?php

declare(strict_types=1);

namespace Tests\Unit\Festival\Service;

use App\Ticket\Modules\Festival\Service\FestivalService;
use App\Ticket\Pagination\Pagination;
use Tests\TestCase;

class FestivalServiceTest extends TestCase
{
    private FestivalService $festivalService;

    public function testGetList(): void
    {
        $pagination = new Pagination(1);

        self::assertNotEmpty($this->festivalService->getList($pagination));
        self::assertNotNull($pagination->getTotal());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->festivalService = $this->app->get(FestivalService::class);
    }
}
