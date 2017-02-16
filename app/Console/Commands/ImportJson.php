<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importjson';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Json';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('importing...');

        $official = array('2017-01-01', '2017-04-14','2017-04-17','2017-05-01','2017-05-29','2017-08-28','2017-12-25','2017-12-26');

        // I'm just going to do 2017 for purpose of this test
        for ($i = 1; $i <= 12; $i++) {

            $month = '0'.$i;

            if ($i > 9) $month = $i;

            $url = 'http://holidayapi.app/v1/holidays?country=GB&year=2017&month='.$month;

            $json = json_decode(file_get_contents($url), true);

            if ($json["status"] == 200) {

                foreach ($json["holidays"] as $holiday) {

                    if (in_array($holiday['date'], $official)) {
                        $bank_holiday = 'official';
                    } else {
                        $bank_holiday = 'unofficial';
                    }

                    DB::table('holidays')->insert([
                        'name' => $holiday['name'], 
                        'country' => $holiday['country'], 
                        'date' => $holiday['date'], 
                        'bank_holiday' => $bank_holiday]);
                }
            }
            else {
                $this->error('error importing '.$url);
            }

        }

        $this->info('done!');

    }
}
