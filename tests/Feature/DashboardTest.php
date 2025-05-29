<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/shop')->assertRedirect('/login');
});

test('authenticated users can visit the shop', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/shop')->assertStatus(200);
});
