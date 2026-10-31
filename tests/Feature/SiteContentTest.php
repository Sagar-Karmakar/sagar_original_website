<?php

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use App\Support\SiteImage;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(fn () => $this->admin = User::factory()->create());

it('shows the offer from the admin on the home page', function () {
    $this->get('/')->assertSee('Founding couples')->assertSee('₹4,999')->assertSee('Spots left: 5 of 5');

    $this->actingAs($this->admin)->put('/admin/offer', [
        'label' => 'Early couples', 'price' => 5999, 'spots_total' => 10, 'spots_left' => 3, 'note_title' => '', 'note' => '',
    ])->assertSessionHasNoErrors();

    $this->get('/')->assertSee('Early couples')->assertSee('₹5,999')->assertSee('Spots left: 3 of 10')->assertDontSee('Why so low?');
});

it('hides spots when there are none to show, and says when all are taken', function () {
    $offer = ['label' => 'Founding couples', 'price' => 4999, 'note_title' => 'Why so low?', 'note' => 'First couples.'];

    $this->actingAs($this->admin)->put('/admin/offer', [...$offer, 'spots_total' => 5, 'spots_left' => 0]);
    $this->get('/')->assertSee('All spots are taken for now');

    $this->actingAs($this->admin)->put('/admin/offer', [...$offer, 'spots_total' => '', 'spots_left' => '']);
    $this->get('/')->assertDontSee('Spots left')->assertDontSee('All spots are taken');
});

it('does not allow more spots left than in total', function () {
    $this->actingAs($this->admin)->put('/admin/offer', ['label' => 'Founding couples', 'price' => 4999, 'spots_total' => 5, 'spots_left' => 6])
        ->assertSessionHasErrors('spots_left');
});

it('keeps the reviews section hidden until there is a review to show', function () {
    $this->get('/')->assertDontSee('What couples say');
});

it('lets the admin add, hide, edit and delete reviews', function () {
    $review = ['quote' => 'We laughed together for the first time in months.', 'couple' => 'A couple from Kolkata', 'context' => 'from a free session', 'is_published' => '1'];

    $this->actingAs($this->admin)->post('/admin/reviews', $review)->assertSessionHasErrors('consent');
    $this->actingAs($this->admin)->post('/admin/reviews', [...$review, 'consent' => '1'])->assertSessionHasNoErrors();

    $this->get('/')->assertSee('What couples say')->assertSee('We laughed together for the first time in months.')->assertSee('A couple from Kolkata · from a free session');

    $saved = Review::sole();
    $this->actingAs($this->admin)->get("/admin/reviews/{$saved->id}/edit")->assertOk();
    $this->actingAs($this->admin)->put("/admin/reviews/{$saved->id}", [...$review, 'is_published' => '0', 'consent' => '1'])->assertRedirect('/admin/reviews');
    $this->get('/')->assertDontSee('What couples say');

    $this->actingAs($this->admin)->delete("/admin/reviews/{$saved->id}");
    expect(Review::count())->toBe(0);
});

it('keeps the admin offer and reviews pages behind the login', function () {
    $this->get('/admin/offer')->assertRedirect('/admin/login');
    $this->get('/admin/reviews')->assertRedirect('/admin/login');
    $this->actingAs($this->admin)->get('/admin/offer')->assertOk();
    $this->actingAs($this->admin)->get('/admin/reviews')->assertOk();
});

it('deletes bookings 12 months after the call', function () {
    $booking = fn (string $when) => Booking::create([
        'starts_at' => CarbonImmutable::parse($when), 'ends_at' => CarbonImmutable::parse($when)->addMinutes(20),
        'name' => 'Priya', 'email' => 'priya@example.com', 'phone' => '9876543210', 'language' => 'English', 'partner_joining' => true,
    ]);
    $booking('-13 months');
    $recent = $booking('-11 months');

    $this->artisan('model:prune', ['--model' => [Booking::class]])->assertSuccessful();

    expect(Booking::pluck('id')->all())->toBe([$recent->id]);
});

it('uses a photo from public/images once it is there', function () {
    $path = public_path('images/test-only-photo.png');

    expect(SiteImage::url('test-only-photo'))->toBeNull();

    file_put_contents($path, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII='));
    try {
        expect(SiteImage::url('test-only-photo'))->toContain('/images/test-only-photo.png?v=');
    } finally {
        unlink($path);
    }
});

it('has no placeholders left on public pages', function (string $page) {
    $this->get($page)->assertOk()->assertDontSee('[your')->assertDontSee('[Your')->assertDontSee('[date]')->assertDontSee('[city]');
})->with(['/', '/about', '/books', '/call', '/privacy-policy', '/terms-and-conditions', '/refund-policy']);
