<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\EmiPayment;
use App\Models\FlatBookingModel;
use App\Models\Contact;
use App\Services\SMSService;

class SendEmiReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emi:send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled EMI reminder SMS to clients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        DB::transaction(function () use ($today) {
            // Client wise group — latest unpaid EMI per booking
            EmiPayment::select('booking_id', DB::raw('MAX(emi_due_date) as latest_due_date'))
                    ->whereIn('booking_id', function($query) {
                        $query->select('booking_id')
                            ->from('emi_payments');
                    })
                    ->groupBy('booking_id')
                    ->orderBy('booking_id')
                    ->chunk(100, function ($groups) use ($today) {
                    foreach ($groups as $group) {
                        $booking = FlatBookingModel::find($group->booking_id);
                        if (!$booking) continue;

                        $contact = Contact::find($booking->client_id);
                        if (!$contact) continue;

                        // Latest unpaid EMI
                        $emi = EmiPayment::where('booking_id', $group->booking_id)
                            ->where('emi_due_date', $group->latest_due_date)
                            ->first();

                        if (!$emi) continue;

                        $latestDue    = Carbon::parse($group->latest_due_date);
                        $daysUntilDue = $today->diffInDays($latestDue, false);
                        $overdueDays  = $daysUntilDue < 0 ? abs($daysUntilDue) : 0;
                        $daysLeft     = $daysUntilDue > 0 ? $daysUntilDue : 0;
                        $message      = null;
                        if ($daysLeft == 3) {
                            $message = "প্রিয় {$contact->first_name} {$contact->last_name}," . PHP_EOL
                                . "আপনার আসন্ন EMI পেমেন্টের কথা মনে করিয়ে দিতে চাই।" . PHP_EOL
                                . "আগামী ৩ দিনের মধ্যে " . number_format($emi->total_amount) . " টাকা পরিশোধ করতে হবে।" . PHP_EOL
                                . "নির্ধারিত তারিখ: {$group->latest_due_date}" . PHP_EOL
                                . "সময়মতো পেমেন্ট করুন।" . PHP_EOL
                                . "ধন্যবাদ।";

                        } elseif ($daysLeft == 1) {
                            $message = "প্রিয় {$contact->first_name} {$contact->last_name}," . PHP_EOL
                                . "জরুরি বিজ্ঞপ্তি! আপনার EMI পেমেন্টের শেষ তারিখ আগামীকাল।" . PHP_EOL
                                . "পরিশোধযোগ্য পরিমাণ: " . number_format($emi->total_amount) . " টাকা।" . PHP_EOL
                                . "নির্ধারিত তারিখ: {$group->latest_due_date}" . PHP_EOL
                                . "অনুগ্রহ করে দ্রুত পেমেন্ট করুন।" . PHP_EOL
                                . "ধন্যবাদ।";

                        } elseif ($daysUntilDue < 0 && $overdueDays == 83) {
                            $message = "প্রিয় {$contact->first_name} {$contact->last_name}," . PHP_EOL
                                . "সতর্কবার্তা! আপনার " . number_format($emi->total_amount) . " টাকার EMI পেমেন্ট প্রায় ৩ মাস ধরে বকেয়া রয়েছে।" . PHP_EOL
                                . "আগামী ১ সপ্তাহের মধ্যে পেমেন্ট না করলে আপনার চুক্তি বাতিল করা হবে।" . PHP_EOL
                                . "অনুগ্রহ করে অবিলম্বে আমাদের সাথে যোগাযোগ করুন।" . PHP_EOL
                                . "ধন্যবাদ।";

                        } elseif ($daysUntilDue < 0 && $overdueDays == 87) {
                            $message = "প্রিয় {$contact->first_name} {$contact->last_name}," . PHP_EOL
                                . "চূড়ান্ত সতর্কবার্তা! আপনার " . number_format($emi->total_amount) . " টাকার EMI পেমেন্ট ৩ মাস ধরে বকেয়া রয়েছে।" . PHP_EOL
                                . "আগামী ৩ দিনের মধ্যে পেমেন্ট না পেলে আপনার চুক্তি বাতিল করা হবে।" . PHP_EOL
                                . "অনুগ্রহ করে এখনই আমাদের সাথে যোগাযোগ করুন।" . PHP_EOL
                                . "ধন্যবাদ।";
                        }

                        if ($message) {
                            SMSService::send('88' . $contact->phone, $message);
                            SMSService::send('88' . '01812005333', $message);
                            SMSService::send('88' . '01814783810', $message);
                        }
                    }
                });
        });
        \Log::info('Scheduled EMI messages sent successfully at ' . now());
        $this->info('EMI reminders sent successfully!');
        return 0;
    }
}
