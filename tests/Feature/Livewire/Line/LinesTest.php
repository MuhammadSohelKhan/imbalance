<?php

namespace Tests\Feature\Livewire\Line;

use App\Http\Livewire\Line\Lines;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LinesTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Lines::class);

        $component->assertStatus(200);
    }
}
