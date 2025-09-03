<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = Project::first() ?? Project::factory()->create();
    
        Issue::factory(20)->create()->each(function ($issue) {
            $issue->project_id = Project::inRandomOrder()->first()->id;
            $issue->save();

            $users = User::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $issue->users()->attach($users);
        });
}
}
