<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepository $userRepository;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = app(UserRepository::class);
    }

    #[Test]
    public function decrementCoins()
    {
        $user = User::factory()->create(['coins' => 10]);

        $this->assertEquals(10, $user->coins);

        $this->userRepository->decrementCoins($user->id, 2);

        $user->refresh();

        $this->assertEquals(8, $user->coins);
    }
}
