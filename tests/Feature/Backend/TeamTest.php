<?php

namespace Tests\Feature\Hotel;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Team;
use App\Models\BookArea;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    protected $hotelUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->hotelUser = User::factory()->create([
            'role' => 'hotel',
        ]);

        $this->actingAs($this->hotelUser);
    }

    public function test_can_view_all_teams()
    {
        Team::factory()->count(3)->create(['hotel_id' => $this->hotelUser->id]);

        $response = $this->get(route('hotel.all.team'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.team.all_team');
        $response->assertViewHas('team');
    }

    public function test_can_view_add_team_page()
    {
        $response = $this->get(route('hotel.add.team'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.team.add_team');
    }

    public function test_can_store_new_team()
    {
        Storage::fake('public');

        $response = $this->post(route('hotel.team.store'), [
            'name' => 'John Doe',
            'position' => 'Manager',
            'facebook' => 'https://facebook.com/john',
        ]);

        $response->assertRedirect(route('hotel.all.team'));
        $this->assertDatabaseHas('teams', [
            'name' => 'John Doe',
            'hotel_id' => $this->hotelUser->id,
        ]);
    }

    public function test_can_view_edit_team_page()
    {
        $team = Team::factory()->create(['hotel_id' => $this->hotelUser->id]);

        $response = $this->get(route('hotel.edit.team', $team->id));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.team.edit_team');
        $response->assertViewHas('team', $team);
    }

    public function test_can_update_team_without_image()
    {
        $team = Team::factory()->create(['hotel_id' => $this->hotelUser->id]);

        $response = $this->post(route('hotel.team.update'), [
            'id' => $team->id,
            'name' => 'Updated Name',
            'position' => 'Lead',
            'facebook' => 'https://facebook.com/updated',
        ]);

        $response->assertRedirect(route('hotel.all.team'));
        $this->assertDatabaseHas('teams', ['id' => $team->id, 'name' => 'Updated Name']);
    }

    public function test_can_update_team_with_image()
    {
        Storage::fake('public');
        $team = Team::factory()->create(['hotel_id' => $this->hotelUser->id]);

        $response = $this->post(route('hotel.team.update'), [
            'id' => $team->id,
            'name' => 'New Name',
            'position' => 'Lead',
            'facebook' => 'https://facebook.com/lead',
        ]);

        $response->assertRedirect(route('hotel.all.team'));
        $this->assertDatabaseHas('teams', ['id' => $team->id, 'name' => 'New Name']);
    }

    public function test_can_view_book_area_page()
    {
        $book = BookArea::factory()->create(['hotel_id' => $this->hotelUser->id]);

        $response = $this->get(route('hotel.book.area'));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.backend.bookarea.book_area');
        $response->assertViewHas('book', $book);
    }

    public function test_can_update_book_area_without_image()
    {
        $book = BookArea::factory()->create(['hotel_id' => $this->hotelUser->id]);

        $response = $this->post(route('hotel.book.area.update'), [
            'short_title' => 'Short',
            'main_title' => 'Main',
            'short_desc' => 'Desc',
            'link_url' => 'https://link.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('book_areas', [
            'hotel_id' => $this->hotelUser->id,
            'short_title' => 'Short',
        ]);
    }
}
