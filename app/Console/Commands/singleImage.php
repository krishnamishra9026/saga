<?php

namespace App\Console\Commands;
use DB;
use Illuminate\Console\Command;

class singleImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:singleImage';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $ids = DB::table('products')->where('image', 'like', '%' . 'post' . '%')->pluck('id');
        
        $image_data = DB::table('products')->whereNotNull('image')->where('category_id',19)->where('sub_category_id',25)->get();
        
        foreach($image_data as $key){
                $url = $key->image;
                //$urls = explode(" | ",$url);
                
             //   for ($i = 0; $i < 4; $i++) {
                    
                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
            
                $data = curl_exec($ch);
                $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
                $pathinfo = pathinfo($url);
                $extension = 'jpg';

                curl_close($ch);

                $image_name = 'mvcode_image_'.$key->id.'_'.rand().'.'.$extension.'';

                $img = public_path('/images/test') .'/'. $image_name;

                file_put_contents( $img, $data );
                
              //  }
            //    $image_new = implode('|',$image_name);

                DB::table('products')->where('id',$key->id)
                ->update(['image'=> $image_name]);
    
            }
        echo "File downloaded!";
    
    }
}
