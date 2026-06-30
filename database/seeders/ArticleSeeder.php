<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin    = User::where('role', 'admin')->first();
        $pantai   = Category::where('slug', 'pantai')->first();
        $gunung   = Category::where('slug', 'gunung')->first();
        $sejarah  = Category::where('slug', 'sejarah')->first();
        $kuliner  = Category::where('slug', 'kuliner')->first();
        $alam     = Category::where('slug', 'alam')->first();
        $kota     = Category::where('slug', 'kota')->first();

        $articles = [
            [
                'category'          => $pantai,
                'title'             => 'Eksotika Pantai Losari, Jantung Kota Makassar',
                'content'           => '<p>Pantai Losari adalah ikon kota Makassar yang terkenal dengan keindahan senja dan sajian kuliner khas Sulawesi Selatan. Terletak di pusat kota, pantai ini menjadi tempat favorit warga lokal maupun wisatawan untuk bersantai menikmati angin sepoi-sepoi sambil menyaksikan matahari terbenam.</p><p>Berbeda dari pantai-pantai di Indonesia pada umumnya, Pantai Losari tidak memiliki hamparan pasir yang luas. Justru keunikannya terletak pada suasana tepi laut kota yang hidup, dilengkapi dengan deretan warung kuliner yang menyajikan menu khas seperti pisang epe, coto Makassar, dan es pisang ijo.</p><p>Di ujung selatan pantai, terdapat Anjungan Pantai Losari yang menjadi spot foto paling ikonik dengan tulisan besar "Pantai Losari". Tempat ini ramai dikunjungi terutama pada sore hingga malam hari.</p>',
                'location_name'     => 'Makassar, Sulawesi Selatan',
                'ticket_price_info' => 'Gratis (area publik)',
                'operating_hours'   => '24 jam',
                'latitude'          => -5.1359,
                'longitude'         => 119.4063,
                'views'             => 1520,
                'status'            => 'published',
            ],
            [
                'category'          => $gunung,
                'title'             => 'Mendaki Keagungan Gunung Rinjani, Lombok',
                'content'           => '<p>Gunung Rinjani (3.726 mdpl) adalah gunung tertinggi kedua di Indonesia dan menjadi salah satu destinasi pendakian paling menantang sekaligus memukau di nusantara. Terletak di Pulau Lombok, Nusa Tenggara Barat, gunung berapi aktif ini menyimpan keindahan alam yang tiada duanya.</p><p>Puncak Rinjani menawarkan pemandangan Danau Segara Anak yang berwarna biru kehijauan, dikelilingi tebing-tebing curam dan sembulan asap dari kawah aktif. Jalur pendakian populer tersedia dari Senaru di sisi utara dan Sembalun di sisi timur.</p><p>Pendakian biasanya memakan waktu 3-4 hari untuk mencapai puncak dan kembali. Selama perjalanan, pendaki akan disuguhi padang savana luas, hutan tropis lebat, dan panorama matahari terbit yang spektakuler.</p>',
                'location_name'     => 'Lombok, Nusa Tenggara Barat',
                'ticket_price_info' => 'Rp 150.000 - Rp 350.000 (tergantung jalur)',
                'operating_hours'   => 'Setiap hari (cuaca memungkinkan)',
                'latitude'          => -8.4124,
                'longitude'         => 116.4650,
                'views'             => 2340,
                'status'            => 'published',
            ],
            [
                'category'          => $sejarah,
                'title'             => 'Kemegahan Candi Borobudur, Warisan Dunia di Magelang',
                'content'           => '<p>Candi Borobudur adalah candi Buddha terbesar di dunia dan merupakan salah satu dari Tujuh Keajaiban Dunia. Dibangun pada abad ke-8 dan ke-9 Masehi oleh Dinasti Sailendra, candi ini merupakan mahakarya arsitektur yang menjadi kebanggaan Indonesia.</p><p>Terdiri dari 9 platform bertumpuk, dihiasi 2.672 panel relief dan 504 arca Buddha, Borobudur menceritakan perjalanan spiritual manusia menuju pencerahan. Dari puncak stupa utama, pengunjung dapat menikmati panorama matahari terbit yang memukau dengan latar Gunung Merapi dan Merbabu.</p><p>Candi ini telah ditetapkan sebagai Situs Warisan Dunia UNESCO sejak 1991 dan dikunjungi oleh jutaan wisatawan setiap tahunnya.</p>',
                'location_name'     => 'Magelang, Jawa Tengah',
                'ticket_price_info' => 'Rp 50.000 (dalam negeri) / USD 25 (mancanegara)',
                'operating_hours'   => '06.00 - 17.00 WIB',
                'latitude'          => -7.6079,
                'longitude'         => 110.2038,
                'views'             => 3100,
                'status'            => 'published',
            ],
            [
                'category'          => $kuliner,
                'title'             => 'Wisata Kuliner Rendang: Cita Rasa Asli Padang',
                'content'           => '<p>Rendang adalah masakan khas Minangkabau dari Sumatera Barat yang telah dinobatkan sebagai salah satu makanan terlezat di dunia oleh CNN Travel. Proses memasak rendang yang membutuhkan waktu berjam-jam menghasilkan daging yang kaya rempah dengan tekstur yang khas.</p><p>Di Kota Padang, Anda dapat menemukan rendang autentik di berbagai rumah makan Padang yang tersebar di seluruh penjuru kota. Setiap rumah makan memiliki resep turun-temurun yang sedikit berbeda, menciptakan variasi rasa yang unik namun tetap mempertahankan ciri khas rendang asli.</p><p>Selain rendang, wisata kuliner Padang juga menawarkan aneka hidangan lezat seperti sate Padang, gulai kepala ikan, dan dendeng batokok yang tak kalah menggugah selera.</p>',
                'location_name'     => 'Padang, Sumatera Barat',
                'ticket_price_info' => 'Mulai Rp 30.000 per porsi',
                'operating_hours'   => '07.00 - 22.00 WIB',
                'latitude'          => -0.9471,
                'longitude'         => 100.4172,
                'views'             => 890,
                'status'            => 'published',
            ],
            [
                'category'          => $alam,
                'title'             => 'Surga Tersembunyi: Air Terjun Nungnung Bali',
                'content'           => '<p>Air Terjun Nungnung adalah salah satu air terjun tertinggi dan paling spektakuler di Bali dengan ketinggian mencapai 50 meter. Terletak di Desa Pelaga, Badung, tempat wisata alam ini menawarkan kesegaran dan keindahan alam yang autentik jauh dari keramaian wisata Bali pada umumnya.</p><p>Untuk mencapai air terjun ini, pengunjung harus menuruni sekitar 500 anak tangga di tengah hutan tropis yang rimbun. Perjalanan turun membutuhkan waktu sekitar 20-30 menit, namun setiap langkahnya terbayar dengan keindahan yang menakjubkan di ujung perjalanan.</p><p>Debit air yang deras menciptakan kabut tipis yang menyegarkan dan pelangi kecil di sekitar kolam terjunan. Kawasan ini juga dikenal dengan udara yang sejuk karena berada di ketinggian sekitar 900 mdpl.</p>',
                'location_name'     => 'Badung, Bali',
                'ticket_price_info' => 'Rp 20.000 per orang',
                'operating_hours'   => '08.00 - 18.00 WITA',
                'latitude'          => -8.3564,
                'longitude'         => 115.1832,
                'views'             => 675,
                'status'            => 'published',
            ],
            [
                'category'          => $kota,
                'title'             => 'Menjelajahi Kota Tua Jakarta: Jejak Sejarah di Batavia',
                'content'           => '<p>Kawasan Kota Tua Jakarta, atau dikenal sebagai "Batavia", adalah jantung bersejarah ibu kota Indonesia. Area seluas 1,3 km persegi ini menyimpan jejak kolonialisme Belanda yang tertuang dalam deretan gedung-gedung berarsitektur Eropa abad ke-17 dan ke-18.</p><p>Taman Fatahillah menjadi pusat kawasan ini, dikelilingi oleh Museum Sejarah Jakarta (Gedung Balaikota lama), Museum Wayang, Museum Seni Rupa dan Keramik, serta Café Batavia. Di malam hari, kawasan ini semakin ramai dengan pertunjukan seni jalanan dan aktivitas komunitas kreatif.</p><p>Bersepeda ontel adalah cara paling populer untuk menjelajahi Kota Tua. Tersedia penyewaan sepeda di sekitar kawasan dengan harga terjangkau. Jangan lewatkan juga Pelabuhan Sunda Kelapa yang tak jauh dari sini.</p>',
                'location_name'     => 'Jakarta Barat, DKI Jakarta',
                'ticket_price_info' => 'Gratis (taman), museum mulai Rp 5.000',
                'operating_hours'   => '09.00 - 21.00 WIB',
                'latitude'          => -6.1352,
                'longitude'         => 106.8133,
                'views'             => 1200,
                'status'            => 'published',
            ],
            [
                'category'          => $pantai,
                'title'             => 'Raja Ampat: Surga Bawah Laut Papua Barat',
                'content'           => '<p>Raja Ampat adalah kepulauan di Papua Barat yang dikenal sebagai salah satu destinasi selam dan snorkeling terbaik di dunia. Terdiri dari lebih dari 1.500 pulau kecil, Raja Ampat menyimpan keanekaragaman hayati laut yang luar biasa dengan lebih dari 600 spesies koral dan 1.700 spesies ikan.</p><p>Keindahan alam Raja Ampat tidak hanya ada di bawah permukaan laut. Pemandangan pulau-pulau karst yang menjulang tinggi dengan hutan hijau yang lebat, dikelilingi air laut berwarna tosca kehijauan, menciptakan panorama yang benar-benar memukau.</p><p>Untuk menuju Raja Ampat, pengunjung dapat terbang ke Sorong kemudian melanjutkan perjalanan dengan speedboat atau kapal feri menuju Waisai, ibukota Kabupaten Raja Ampat.</p>',
                'location_name'     => 'Raja Ampat, Papua Barat',
                'ticket_price_info' => 'Rp 1.000.000 (entry fee tahunan untuk turis asing)',
                'operating_hours'   => 'Sepanjang tahun (terbaik April-Oktober)',
                'latitude'          => -0.2307,
                'longitude'         => 130.5218,
                'views'             => 4500,
                'status'            => 'published',
            ],
            [
                'category'          => $sejarah,
                'title'             => 'Prambanan: Megahnya Candi Hindu Terbesar di Indonesia',
                'content'           => '<p>Candi Prambanan adalah kompleks candi Hindu terbesar di Indonesia dan salah satu yang terbesar di Asia Tenggara. Dibangun pada abad ke-9, candi ini dipersembahkan untuk Trimurti — tiga dewa utama Hindu: Brahma (Pencipta), Wisnu (Pemelihara), dan Siwa (Penghancur).</p><p>Kompleks Prambanan terdiri dari 240 candi dengan candi utama Siwa yang menjulang setinggi 47 meter. Relief-relief indah yang menghiasi dinding candi menceritakan kisah Ramayana dan Krishnayana dengan detail yang luar biasa.</p><p>Setiap tahun, Pertunjukan Sendratari Ramayana Ballet digelar di pelataran candi dengan latar belakang kemegahan Prambanan — menjadi salah satu pertunjukan seni paling spektakuler di Asia.</p>',
                'location_name'     => 'Sleman, Daerah Istimewa Yogyakarta',
                'ticket_price_info' => 'Rp 50.000 (dalam negeri)',
                'operating_hours'   => '06.00 - 18.00 WIB',
                'latitude'          => -7.7520,
                'longitude'         => 110.4914,
                'views'             => 2700,
                'status'            => 'published',
            ],
        ];

        foreach ($articles as $data) {
            $category = $data['category'];
            unset($data['category']);

            $title = $data['title'];
            $slug  = Str::slug($title);

            // Pastikan slug unik
            $count = Article::where('slug', 'like', $slug . '%')->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }

            Article::updateOrCreate(
                ['slug' => $slug],
                array_merge($data, [
                    'user_id'     => $admin->id,
                    'category_id' => $category->id,
                    'slug'        => $slug,
                    'thumbnail'   => null,
                ])
            );
        }

        $this->command->info('✓ ' . count($articles) . ' artikel wisata berhasil dibuat.');
    }
}
