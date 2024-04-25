<?php

namespace App\Console\Commands;

use App\Mail\UpcomingBookReturnReminder;
use App\Models\Book;
use App\Models\BookRent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckUpcomingBookReturnsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:upcoming-book-returns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for upcoming book returns and sends reminder emails.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {

        $upcomingReturns = $this->checkForUpcomingReturns();

        if ($upcomingReturns) {
            foreach ($upcomingReturns as $rental) {

                $rentalData = [
                    'name' => User::find($rental['user_id'])->name,
                    'email' => User::find($rental['user_id'])->email,
                    'book_title' => Book::find($rental['book_id'])->title,
                    'return_date' => $rental['return_date']
                ];

                Mail::to($rentalData['email'])->send(new UpcomingBookReturnReminder($rentalData));
            }

            $this->info('Upcoming book return emails sent successfully.');
        } else {
            $this->info('No upcoming book returns within the reminder window.');
        }

        return 0;
    }

    private function checkForUpcomingReturns(): array
    {
        $today = Carbon::parse(now())->format('d F y');

        // Fetch unreturned rentals
        $unreturnedRentals = BookRent::whereNull('returned_at')
            ->get();

        $upcomingReturns = [];
        foreach ($unreturnedRentals as $rental) {
            $returnDate = Carbon::parse($rental->return_date)->format('d F y');
            if ($returnDate && $returnDate <= $today) {
                $upcomingReturns[] = [
                    'user_id' => $rental->user_id,
                    'book_id' => $rental->book_id,
                    'return_date' => $returnDate
                ];
            }
        }

        return $upcomingReturns;
    }
}
