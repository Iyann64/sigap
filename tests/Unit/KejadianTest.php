<?php

namespace Tests\Unit;

use App\Models\Kejadian;
use Tests\TestCase;

class KejadianTest extends TestCase
{
    public function test_formats_incident_date_and_time_from_cast_datetime(): void
    {
        $kejadian = new Kejadian([
            'tanggal_waktu' => '2026-01-10 08:30:00',
        ]);

        $this->assertSame('10 January 2026', $kejadian->tanggal_format);
        $this->assertSame('08:30', $kejadian->waktu_format);
    }
}
