<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TrainRecommendationModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommendations:train';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Train the ML recommendation model using user-product interactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting ML model training...');

        $mlEngine = app(\App\Services\ML\MLRecommendationEngine::class);

        $success = $mlEngine->trainModel();

        if ($success) {
            $this->info('✓ ML model trained successfully!');
            $this->info('Model saved to storage/app/ml-models/recommendation-model.dat');
            return Command::SUCCESS;
        } else {
            $this->error('✗ ML model training failed. Check logs for details.');
            $this->warn('Possible reasons: Not enough interaction data (minimum 10 required)');
            return Command::FAILURE;
        }
    }
}
