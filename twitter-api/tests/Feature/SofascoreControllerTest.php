<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\SofascoreController;

class SofascoreControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test determine if function returns the total correct score
     *
     * @return void
     */
    public function testDetermineTotalScoreReturnsTheCorrectTotalScore()
    {
        $sofascore = new SofascoreController();
        $home_results = '{"current":0,"display":0,"period1":8,"period2":4,"period3":4,"normaltime":0}';
        $away_resuts = '{"current":3,"display":3,"period1":11,"period2":11,"period3":11,"normaltime":3}';
        $result = $sofascore->determineTotalScore(
            $home_results,
            $away_resuts
        );
        $expected_result = [
            'home_total' => 16,
            'away_total' => 33,
            'both_total' => 49,
            'updated_score' => 2
        ];
        $this->assertIsArray($result);
        $this->assertArrayHasKey('home_total', $result);
        $this->assertArrayHasKey('away_total', $result);
        $this->assertArrayHasKey('both_total', $result);
        $this->assertArrayHasKey('updated_score', $result);
        $this->assertEquals($expected_result, $result);
    }

}
