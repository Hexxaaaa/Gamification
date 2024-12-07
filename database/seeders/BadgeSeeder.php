<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $badges = [
            [
                'name' => 'Beginner Explorer',
                'description' => 'Welcome to PointPlay! You\'ve taken your first steps.',
                'points_required' => 0,
                'level' => 1,
                'status' => 'available'
            ],
            [
                'name' => 'Active Participant',
                'description' => 'Actively engaging with tasks and earning points.',
                'points_required' => 750,
                'level' => 2,
                'status' => 'locked'
            ],
            [
                'name' => 'Dedicated User',
                'description' => 'Showing consistent participation and achievement.',
                'points_required' => 1000,
                'level' => 3,
                'status' => 'locked'
            ],
            [
                'name' => 'Expert Contributor',
                'description' => 'Making significant contributions to the platform.',
                'points_required' => 2000,
                'level' => 4,
                'status' => 'locked'
            ],
            [
                'name' => 'Platform Master',
                'description' => 'Demonstrating mastery of platform engagement.',
                'points_required' => 3000,
                'level' => 5,
                'status' => 'locked'
            ],
            [
                'name' => 'Elite Champion',
                'description' => 'Reaching the pinnacle of achievement.',
                'points_required' => 1000000,
                'level' => 10,
                'status' => 'locked'
            ]
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}