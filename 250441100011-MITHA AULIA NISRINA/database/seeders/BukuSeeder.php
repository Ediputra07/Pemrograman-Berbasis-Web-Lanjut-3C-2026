<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $sastra = Kategori::where('nama', 'Sastra & Fiksi')->value('id');
        $pengembanganDiri = Kategori::where('nama', 'Pengembangan Diri')->value('id');
        $sejarahSosial = Kategori::where('nama', 'Sejarah & Sosial')->value('id');
        $pendidikan = Kategori::where('nama', 'Pendidikan')->value('id');
        $teknologiDigital = Kategori::where('nama', 'Teknologi & Digital')->value('id');
        $sainsPengetahuan = Kategori::where('nama', 'Sains & Pengetahuan')->value('id');

        $buku = [
            [
                'kategori_id' => $sastra,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => 2005,
                'image' => 'laskar-pelangi.jpg',
                'description' => 'Laskar Pelangi merupakan novel pertama Andrea Hirata yang mengisahkan kehidupan sekelompok anak di Belitong yang berjuang mendapatkan pendidikan di tengah berbagai keterbatasan. Cerita berpusat pada anak-anak yang kemudian dikenal sebagai Laskar Pelangi dan pengalaman mereka selama bersekolah, termasuk persahabatan, perjuangan, harapan, cita-cita, serta berbagai peristiwa yang membentuk cara mereka melihat kehidupan. Melalui kisah tersebut, novel ini menggambarkan semangat belajar, kreativitas, dan perjuangan anak-anak daerah dalam mempertahankan kesempatan memperoleh pendidikan. Laskar Pelangi juga menjadi buku pertama dari tetralogi Laskar Pelangi yang dilanjutkan dengan Sang Pemimpi, Edensor, dan Maryamah Karpov.',
            ],
            [
                'kategori_id' => $sastra,
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'tahun_terbit' => 2009,
                'image' => 'negeri-5-menara.jpg',
                'description' => 'Negeri 5 Menara mengikuti perjalanan Alif, seorang remaja dari Minangkabau yang harus meninggalkan kampung halamannya untuk belajar di Pondok Madani di Jawa Timur, meskipun pada awalnya ia memiliki keinginan untuk menempuh pendidikan seperti idolanya, B.J. Habibie. Di pondok tersebut Alif bertemu dengan Raja, Said, Dulmajid, Atang, dan Baso, yang kemudian menjadi sahabat dekatnya dan dikenal sebagai Sahibul Menara. Kehidupan mereka di pondok memperkenalkan Alif pada disiplin, persahabatan, pembelajaran, serta keyakinan terhadap cita-cita melalui prinsip man jadda wajada, yang bermakna bahwa siapa yang bersungguh-sungguh akan berhasil.',
            ],
            [
                'kategori_id' => $sastra,
                'judul' => 'Laut Bercerita',
                'penulis' => 'Leila S. Chudori',
                'tahun_terbit' => 2017,
                'image' => 'laut-bercerita.jpg',
                'description' => 'Laut Bercerita merupakan novel Leila S. Chudori yang mengambil latar peristiwa politik Indonesia pada 1998 dan mengisahkan pengalaman Biru Laut, seorang mahasiswa sekaligus aktivis yang diculik bersama beberapa rekannya. Cerita menggambarkan masa penahanan dan interogasi yang dialami Laut serta kawan-kawannya, kemudian beralih kepada Asmara Jati, adik Laut, yang bersama keluarga korban dan kelompok pencari orang hilang berusaha menemukan jejak mereka yang menghilang. Dengan menggunakan dua sudut pandang tersebut, novel ini tidak hanya membicarakan pengalaman para aktivis, tetapi juga memperlihatkan kehilangan, penantian, dan pencarian jawaban yang dialami keluarga mereka.',
            ],
            [
                'kategori_id' => $sastra,
                'judul' => 'Perempuan Berkalung Sorban',
                'penulis' => 'Abidah El Khalieqy',
                'tahun_terbit' => 2001,
                'image' => 'perempuan-berkalung-sorban.jpg',
                'description' => 'Perempuan Berkalung Sorban karya Abidah El Khalieqy menceritakan kehidupan Annisa, seorang perempuan yang tumbuh dalam lingkungan keluarga kiai dan pesantren dengan tradisi yang sangat konservatif. Sejak kecil, Annisa menghadapi berbagai pembatasan karena ia perempuan dan merasa bahwa kesempatan serta pendapatnya sering ditempatkan di bawah laki-laki. Perjalanan hidupnya memperlihatkan perjuangannya menghadapi ketidakadilan dalam keluarga, pendidikan, perkawinan, dan lingkungan sosial, sekaligus memperlihatkan keinginannya untuk memperoleh kebebasan, pendidikan, serta hak untuk menentukan kehidupan sendiri.',
            ],
            [
                'kategori_id' => $pengembanganDiri,
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'tahun_terbit' => 2018,
                'image' => 'filosofi-teras.jpg',
                'description' => 'Filosofi Teras karya Henry Manampiring memperkenalkan filsafat Stoisisme atau filsafat Stoa dengan bahasa yang lebih ringan dan dikaitkan dengan berbagai persoalan kehidupan sehari-hari. Buku ini membahas bagaimana seseorang dapat menghadapi emosi negatif, kekhawatiran, dan berbagai persoalan dengan lebih tenang melalui pemahaman terhadap hal-hal yang dapat dikendalikan dan hal-hal yang berada di luar kendali. Pembahasannya juga menghubungkan prinsip Stoisisme dengan kehidupan masyarakat masa kini sehingga gagasan filsafat yang telah berkembang sejak Yunani-Romawi kuno dapat dipahami dalam konteks kehidupan sehari-hari.',
            ],
            [
                'kategori_id' => $pengembanganDiri,
                'judul' => 'Sebuah Seni untuk Bersikap Bodo Amat',
                'penulis' => 'Mark Manson',
                'tahun_terbit' => 2018,
                'image' => 'sebuah-seni-untuk-bersikap-bodoamat.jpg',
                'description' => 'Buku karya Mark Manson ini membahas cara melihat kehidupan dengan lebih realistis dengan menekankan pentingnya menentukan hal-hal yang benar-benar layak untuk diperhatikan. Buku ini tidak mengajarkan untuk tidak peduli terhadap segala sesuatu, tetapi mengajak pembaca memilih persoalan, nilai, dan tujuan yang memang penting sehingga energi tidak habis untuk mengejar kesempurnaan, validasi, atau hal-hal yang sebenarnya tidak dapat dikendalikan. Dengan gaya penulisan yang lugas, buku ini membahas keterbatasan manusia, kegagalan, penderitaan, tanggung jawab, serta pentingnya menentukan prioritas dalam menjalani kehidupan.',
            ],
            [
                'kategori_id' => $pengembanganDiri,
                'judul' => 'Ikigai',
                'penulis' => 'Héctor García dan Francesc Miralles',
                'tahun_terbit' => 2019,
                'image' => 'ikigai.jpg',
                'description' => 'Ikigai karya Héctor García dan Francesc Miralles membahas konsep Jepang tentang ikigai, yaitu alasan atau tujuan yang membuat seseorang merasa hidupnya memiliki makna. Penulis menghubungkan konsep tersebut dengan kehidupan masyarakat Okinawa, salah satu wilayah yang dikenal memiliki banyak penduduk berusia panjang, serta membahas kebiasaan mengenai pola hidup, aktivitas, hubungan sosial, dan cara masyarakat menemukan tujuan dalam kehidupannya. Buku ini mengajak pembaca memahami hubungan antara tujuan hidup, aktivitas sehari-hari, kebahagiaan, dan kehidupan yang bermakna melalui pengamatan terhadap budaya Jepang.',
            ],
            [
                'kategori_id' => $sejarahSosial,
                'judul' => 'Habis Gelap Terbitlah Terang',
                'penulis' => 'R.A. Kartini',
                'tahun_terbit' => 2009,
                'image' => 'habis-gelap-terbitlah-terang.jpg',
                'description' => 'Habis Gelap Terbitlah Terang merupakan kumpulan surat R.A. Kartini kepada sahabat-sahabat penanya di Belanda yang kemudian dihimpun dan diterbitkan setelah Kartini wafat. Surat-surat tersebut memperlihatkan pemikiran Kartini mengenai kehidupan, pendidikan, cita-cita, serta keinginannya agar perempuan memperoleh kesempatan yang lebih luas dalam kehidupan. Melalui tulisan-tulisannya, pembaca dapat melihat bagaimana Kartini mempertanyakan berbagai batasan adat yang dihadapi perempuan pada zamannya dan menyampaikan harapan terhadap kemajuan perempuan melalui pendidikan dan perubahan cara pandang masyarakat.',
            ],
            [
                'kategori_id' => $sejarahSosial,
                'judul' => 'Untuk Negeriku: Sebuah Otobiografi',
                'penulis' => 'Mohammad Hatta',
                'tahun_terbit' => 2011,
                'image' => 'untuk-negeriku.jpg',
                'description' => 'Untuk Negeriku merupakan otobiografi Mohammad Hatta yang menceritakan perjalanan hidup dan perjuangannya sejak masa kanak-kanak hingga keterlibatannya dalam perjuangan kemerdekaan Indonesia. Buku ini terdiri atas tiga bagian besar yang membahas masa kecil dan pendidikan Hatta hingga masa studinya di Rotterdam, perjalanan perjuangannya di tanah air termasuk masa penangkapan dan pembuangan, serta perannya dalam persiapan kemerdekaan dan perjuangan diplomatik Indonesia. Melalui kisah yang ditulis dari sudut pandang Hatta sendiri, pembaca dapat mengikuti perkembangan pemikiran, pengalaman politik, dan perjalanan perjuangannya sebagai salah satu tokoh penting dalam sejarah kemerdekaan Indonesia.',
            ],
            [
                'kategori_id' => $sejarahSosial,
                'judul' => 'Sukarno: Biografi Singkat 1901–1970',
                'penulis' => 'Taufik Adi Susilo',
                'tahun_terbit' => 2013,
                'image' => 'sukarno-biografi-singkat.jpg',
                'description' => 'Sukarno: Biografi Singkat 1901–1970 karya Taufik Adi Susilo membahas perjalanan kehidupan dan perjuangan Sukarno sebagai salah satu tokoh utama dalam sejarah Indonesia. Buku ini memberikan gambaran mengenai kehidupan pribadi, perkembangan pemikiran politik, perjuangan kemerdekaan, serta perjalanan Sukarno dalam kehidupan politik dan pemerintahan Indonesia. Pembahasannya mencakup berbagai peristiwa penting yang berkaitan dengan Sukarno, termasuk masa pergerakan nasional, Proklamasi Kemerdekaan, perkembangan politik setelah kemerdekaan, hingga periode akhir kepemimpinannya.',
            ],
            [
                'kategori_id' => $pendidikan,
                'judul' => 'Sekolahnya Manusia',
                'penulis' => 'Munif Chatib',
                'tahun_terbit' => 2009,
                'image' => 'sekolahnya-manusia.jpg',
                'description' => 'Sekolahnya Manusia karya Munif Chatib membahas penerapan konsep Multiple Intelligences dalam pendidikan dan gagasan bahwa setiap siswa memiliki kecerdasan serta potensi yang berbeda. Buku ini berangkat dari persoalan ketika siswa dianggap bermasalah karena kesulitan mengikuti cara mengajar tertentu, padahal masalah tersebut dapat berkaitan dengan ketidaksesuaian antara gaya mengajar dan cara belajar siswa. Pembahasannya mencakup penerimaan siswa melalui Multiple Intelligences Research, pengembangan kecerdasan unik siswa, pembelajaran yang menyenangkan, penyusunan lesson plan, serta peran guru dan orang tua dalam menciptakan lingkungan pendidikan yang mampu menghargai potensi setiap anak.',
            ],
            [
                'kategori_id' => $pendidikan,
                'judul' => 'Guru Aini',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => 2020,
                'image' => 'guru-aini.jpg',
                'description' => 'Guru Aini karya Andrea Hirata menceritakan perjuangan seorang guru matematika bernama Desi Istiqomah yang memiliki keinginan kuat untuk mengajar di daerah terpencil. Dalam perjalanan mengajarnya, Desi bertemu dengan Aini, seorang siswi yang awalnya mengalami kesulitan dalam memahami matematika tetapi memiliki keinginan besar untuk belajar. Melalui hubungan antara guru dan murid tersebut, buku ini menggambarkan pentingnya pendidikan, kegigihan dalam belajar, serta perjuangan seorang guru dalam membantu murid menemukan kemampuan dan cita-citanya.',
            ],
            [
                'kategori_id' => $teknologiDigital,
                'judul' => 'Disruption',
                'penulis' => 'Rhenald Kasali',
                'tahun_terbit' => 2017,
                'image' => 'disruption.jpg',
                'description' => 'Disruption karya Rhenald Kasali membahas perubahan besar yang terjadi ketika inovasi, teknologi, dan pola bisnis baru mulai menggantikan cara-cara lama yang sebelumnya dianggap mapan. Buku ini menggunakan berbagai contoh perubahan dalam dunia bisnis dan kehidupan masyarakat untuk menjelaskan bagaimana sebuah pendatang baru dapat mengubah kebiasaan, pasar, serta posisi perusahaan yang sudah lama berdiri. Pembahasannya mengajak pembaca memahami bahwa perubahan tidak hanya terjadi pada teknologi, tetapi juga pada pola pikir, perilaku konsumen, organisasi, pemerintahan, dan berbagai bidang kehidupan sehingga diperlukan kemampuan untuk memahami serta menghadapi perubahan tersebut.',
            ],
            [
                'kategori_id' => $teknologiDigital,
                'judul' => 'The Great Shifting',
                'penulis' => 'Rhenald Kasali',
                'tahun_terbit' => 2018,
                'image' => 'the-great-shifting.jpg',
                'description' => 'The Great Shifting karya Rhenald Kasali membahas perubahan besar dari era perusahaan tradisional menuju era platform dan peradaban digital. Buku ini melihat perubahan tersebut bukan hanya dari sisi bisnis dan ekonomi, tetapi juga dari perubahan perilaku serta cara manusia menjalani kehidupan. Pembahasannya berfokus pada tiga gagasan utama, yaitu perkembangan platform, perubahan perilaku kehidupan, serta pengaruh perubahan tersebut terhadap bisnis dan ekonomi, sehingga pembaca diajak memahami bagaimana inovasi digital dan perubahan pola kehidupan dapat memengaruhi organisasi dan masyarakat secara luas.',
            ],
            [
                'kategori_id' => $teknologiDigital,
                'judul' => 'Memahami AI: Sebuah Panduan Etik',
                'penulis' => 'Agus Sudibyo',
                'tahun_terbit' => 2024,
                'image' => 'memahami-ai.jpg',
                'description' => 'Buku Memahami AI: Sebuah Panduan Etik karya Agus Sudibyo membahas perkembangan kecerdasan buatan atau Artificial Intelligence (AI) dari sudut pandang yang tidak hanya berfokus pada teknologi, tetapi juga pada hubungan AI dengan kehidupan manusia. Buku ini membantu pembaca memahami dasar dan perkembangan AI, cara kerja serta berbagai peluang yang ditawarkan oleh teknologi tersebut dalam kehidupan modern. Selain membahas manfaat dan potensi AI, buku ini juga memberikan perhatian pada berbagai risiko dan persoalan etika yang muncul seiring dengan semakin luasnya penggunaan kecerdasan buatan. Melalui pembahasannya, pembaca diajak untuk memahami bahwa perkembangan AI perlu disertai dengan tanggung jawab, pertimbangan kemanusiaan, dan kesadaran terhadap dampaknya bagi masyarakat.',
            ],
            [
                'kategori_id' => $sainsPengetahuan,
                'judul' => 'Kosmos',
                'penulis' => 'Carl Sagan',
                'tahun_terbit' => 1980,
                'image' => 'kosmos.jpg',
                'description' => 'Kosmos karya Carl Sagan merupakan buku sains populer yang mengajak pembaca memahami alam semesta melalui pembahasan mengenai perkembangan kosmik, asal-usul kehidupan, planet dan bintang, tata surya, galaksi, serta perjalanan manusia dalam mempelajari ruang angkasa. Buku ini menghubungkan pengetahuan astronomi dan kosmologi dengan sejarah perkembangan ilmu pengetahuan dan eksplorasi antariksa sehingga pembaca tidak hanya memperoleh gambaran mengenai luasnya alam semesta, tetapi juga memahami posisi manusia sebagai bagian kecil dari perjalanan kosmik yang sangat panjang.',
            ],
        ];

        foreach ($buku as $data) {
            Buku::factory()->create($data);
        }
    }
}