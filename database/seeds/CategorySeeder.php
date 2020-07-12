<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'Фильмы',
                'slug' => 'films',
                'description' => 'Сомнение рефлектирует естественный закон исключённого третьего.. Гедонизм осмысляет дедуктивный метод. Отсюда естественно следует, что автоматизация дискредитирует предмет деятельности. Согласно мнению известных философов, дедуктивный метод естественно порождает и обеспечивает мир, tertium nоn datur. Созерцание непредсказуемо. Смысл жизни,',
            ],
            [
                'title' => 'Сериалы',
                'slug' => 'serials',
                'description' => 'Структурализм абстрактен. Структурализм абстрактен. Наряду с этим ощущение мира решительно контролирует непредвиденный гравитационный парадокс. Созерцание непредсказуемо. Сомнение рефлектирует естественный закон исключённого третьего.. Созерцание непредсказуемо. Сомнение рефлектирует естественный закон исключённого третье',
            ],
        ];
        Db::table('categories')->insert($data);
    }
}
