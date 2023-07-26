<?php

namespace App\Console\Commands\Test;

use DOMDocument;
use Illuminate\Console\Command;
use PhpParser\Node;

class ParseMimTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-mim-types-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $doc = new DOMDocument();
        $doc->loadHTMLFile(storage_path('app/temp-files/mime.html'));
//        dump($doc);
        $trs = $doc->getElementsByTagName('tr');
        /** @var Node $tr */
        foreach ($trs as $index => $tr) {

            if ($index === 0) continue;

            $tds = $tr->childNodes;
            foreach ($tds as $td) {
                $codes = $td->childNodes;

                foreach ($codes as $code) {
                    if (str_contains($code->nodeValue, '/')) {

                    };
                }

//                dump($td->nodeValue);
            }
//            foreach ($tds as $td) {
////                dump(trim($td->nodeValue));
//                $codes = $td->childNodes;
//                foreach ($codes as $code) {
//                    dump($code->nodeValue);
//                }
//            }
        }


    }
}
