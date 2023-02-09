<?php

namespace Tests\Feature\Livewire\Summary;

use App\Http\Livewire\Summary\Summaries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class SummariesTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Summaries::class);

        $component->assertStatus(200);
    }
}
