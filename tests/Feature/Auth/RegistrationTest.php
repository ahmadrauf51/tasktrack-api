<?php

test('new users can register', function () {
    $response = $this->post(route('api.register.user'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
    $response->assertStatus(201);
    // $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});
