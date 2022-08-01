<?php

namespace Jasester\LaravelChinaAddress\Commands;

use Illuminate\Console\Command;
use Jasester\LaravelChinaAddress\Address;

class ImportAddress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'address:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the address table with address json file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (Address::count()) {
            return $this->error('数据库有数据，请先清理数据库');
        }

        //20190609填充非联动数据,保持和前端组件 address_select 数据一致
        $this->seeding('省/直辖市','json/province.json');
        $this->seeding('城市','json/city.json');
        $this->seeding('区/县','json/area.json');
        $this->seeding('乡/镇/街道办','json/street.json');
    }

    private function seeding($type,$file_name)
    {
        // 从文件中读取数据到PHP变量
        $json_string = file_get_contents(__DIR__.'/../'.$file_name);
        // 用参数true把JSON字符串强制转成PHP数组
        $data = json_decode($json_string, true);
        // 显示出来看看
        $this->info('Start Seeding '.count($data).' '.$type.'...');

        $bar = $this->output->createProgressBar(count($data));
        $bar->start();

        foreach ($data as $item) {
            $code = $item['code'];
            $create = ['code' => $code, 'name' => $item['name'], 'parent_code' => $item['parent'] ?? null];
            $result = Address::create($create);
            if(!$result){
                return $this->error('填充出错...');;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info('---'.$type.' Seed finished...');
    }
}
