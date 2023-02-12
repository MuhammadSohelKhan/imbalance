<?php

namespace Tests\Feature\Livewire\Operation;

use App\Http\Livewire\Operation\Operations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class OperationsTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Operations::class);

        $component->assertStatus(200);
    }
}
