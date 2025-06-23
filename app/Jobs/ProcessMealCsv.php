<?php

namespace App\Jobs;

use App\Models\Meal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Numeric;
use Ramsey\Uuid\Type\Decimal;
use Illuminate\Support\Str;
class ProcessMealCsv implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $filePath;
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $file = file($this->filePath);

        $data = array_map('str_getcsv', $file); //read all rows of csv
        $headers = array_map('strtolower', array_map('trim', $data[0])); //get headers with lower case
        Log::message($headers);
        unset($data[0]); // header removed from the data

        $data = array_combine($headers, $data); // key => value
        $payload = [];
        foreach ($data as $row) {
            $validator = Validator::make(
                $row,
                [
                    'title' => 'required',
                    'meal_category_id' => 'required|exists:meal_category,id',
                ]
            );

            if ($validator->fails()) {
                continue; // skip the perticular entry
            }

            $payload[] = [
                'title' => ucfirst($row['title']).'_'.Str::randome(10),
                'description' => $row['description'] ?? 'Delicious meal!',
                'meal_category_id' => $row['meal_category_id'],
                'quantity' => (int)$row['quantity'],
                'is_available' => (int) $row['is_available'],
                'mrp' => $row['mrp'],
                'picture_path' => $row['picture_path'],
                'discount_percentage' => $row['discount_percentage'],
                'best_seller' => $row['best_seller'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $chunks = array_chunk($payload, 500);
        foreach ($chunks as $chunk) {
            Meal::insert($chunk);
        }

        Log::info('Meal CSV processed successfully.');
    }
}
