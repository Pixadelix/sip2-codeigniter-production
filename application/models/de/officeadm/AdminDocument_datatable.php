<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// DataTables PHP library and database connection
//include_once APPPATH . DATATABLE_EDITOR;

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;
	
load_class('Editor_Model', 'core');
class AdminDocument_datatable extends CI_Editor_Model {
	
	public $table = 'sip_admin_document';
	
	public function __construct() {
		
		parent::__construct();
		$this->create_table();
		$this->init_editor();
		
	}
	
	public function create_table() {

		if ( $this->production() ) return;

        try {
            
            $this->db_datatables->sql(
                "CREATE TABLE IF NOT EXISTS `$this->table` (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `type` varchar(200) NOT NULL,
                    `group` varchar(200) NOT NULL,
                    `refcode` varchar(200) DEFAULT NULL,
                    `refdate` datetime NOT NULL,
                    `notes` text DEFAULT NULL,
                    `content` text DEFAULT NULL,
                    `create_by` mediumint(8) UNSIGNED NOT NULL DEFAULT '1',
                    `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `update_by` mediumint(8) UNSIGNED DEFAULT NULL,
                    `update_at` datetime DEFAULT NULL,

                    PRIMARY KEY( `id` )
                )

                ;" 
            );
		
		
			$this->db_datatables->sql(
				"ALTER TABLE `$this->table` ADD COLUMN IF NOT EXISTS `status` VARCHAR(50) DEFAULT NULL AFTER `content`;"
			);
		}
		
		catch( Exception $e ) {
			//show_error($e->message, 0);
		}
		
	}

	public function migrate() {
		$data = array(
			array('id' =>  26,	'refdate' => NULL		 ,	'refcode' => '26/KET/MV.TMS/0217	', 'notes' => 'SURAT KUASA PPGB                                                                                                     '),
			array('id' =>  27,	'refdate' => NULL		 ,	'refcode' => '27/TT/MV.TMS/0217		', 'notes' => 'GB JAMPEL                                                                                                            '),
			array('id' =>  28,	'refdate' => NULL		 ,	'refcode' => '28/INV.MD/MV.TMS/0217	', 'notes' => 'INV C-News Jan 2017                                                                                                  '),
			array('id' =>  29,	'refdate' => NULL		 ,	'refcode' => '29/INV.MD/MV.TMS/0217	', 'notes' => 'INV C-News Feb 2017                                                                                                  '),
			array('id' =>  30,	'refdate' => NULL		 ,	'refcode' => '30/INV.MD/MV.TMS/0217	', 'notes' => 'e-Magz Info BCA 15                                                                                                   '),
			array('id' =>  31,	'refdate' => NULL		 ,	'refcode' => '31/INV/MV.TMS/0217	', 'notes' => 'Energia PDSI Edisi 19-2017                                                                                           '),
			array('id' =>  32,	'refdate' => NULL		 ,	'refcode' => '32/QUO/MV.TMS/0217	', 'notes' => 'Penawaran Forbes Indonesia                                                                                           '),
			array('id' =>  33,	'refdate' => '27/02/2017',	'refcode' => '33/SDM/MV.TMS/0217	', 'notes' => 'Kontrak Kerja Orizky                                                                                                 '),
			array('id' =>  34,	'refdate' => '27/02/2017',	'refcode' => '34/TT/MV.TMS/0217		', 'notes' => 'Tanda Terima Invoice DMC                                                                                             '),
			array('id' =>  35,	'refdate' => '28/02/2017',	'refcode' => '35/QUO/MV.TMS/0217	', 'notes' => 'Penawaran Pekerjaan Pengadaan Jasa Kreatif Pembuatan Majalah UI Update 6 Edisi Tahun 2017                            '),
			array('id' =>  36,	'refdate' => '01/03/2017',	'refcode' => '36/QUO/MV.TMS/0317	', 'notes' => 'Surat Penawaran ke Forbes                                                                                            '),
			array('id' =>  37,	'refdate' => '01/03/2017',	'refcode' => '37/QUO/MV.TMS/0317	', 'notes' => 'Surat Penawaran Web Site Redesign ke Icon+                                                                           '),
			array('id' =>  38,	'refdate' => '01/03/2017',	'refcode' => '38/QUO/MV.TMS/0317	', 'notes' => 'Surat Penawaran Content Management Service ke Icon+                                                                  '),
			array('id' =>  39,	'refdate' => '03/03/2017',	'refcode' => '39/TT/MV.TMS/0317		', 'notes' => 'Tanda Terima pengiriman dok Perjanjian Kontrak ICONews 2017                                                          '),
			array('id' =>  40,	'refdate' => '03/03/2017',	'refcode' => '40/TT/MV.TMS/0317		', 'notes' => 'Tanda Terima pengembalian GB Penawaran Pengadaan ICONews 2017 ke BNI Syariah                                         '),
			array('id' =>  41,	'refdate' => '07/03/2017',	'refcode' => '41/TT/MV.TMS/0317		', 'notes' => 'Tanda Terima pengiriman foto berupa 8 keping DVD ke DMC                                                              '),
			array('id' =>  42,	'refdate' => '08/03/2017',	'refcode' => '42/PO.CET/MV.TMS/0317	', 'notes' => 'PO cetak di perusahaan                                                                                               '),
			array('id' =>  43,	'refdate' => '10/03/2017',	'refcode' => '43/SEK/MV.TMS/0317	', 'notes' => 'Persetujuan Klien ICON+NEWS edisi Maret 2017                                                                         '),
			array('id' =>  44,	'refdate' => '13/03/2017',	'refcode' => '44/PJK/MV.TMS/0317	', 'notes' => 'Permintaan Data e-Faktur                                                                                             '),
			array('id' =>  45,	'refdate' => '13/03/2017',	'refcode' => '45/QUO/MV.TMS/0317	', 'notes' => 'Penawaran Panorama Event Website                                                                                     '),
			array('id' =>  46,	'refdate' => '13/03/2017',	'refcode' => '46/QUO/MV.TMS/0317	', 'notes' => 'Penawaran Panorama Event Maintenance Content                                                                         '),
			array('id' =>  47,	'refdate' => '15/03/2017',	'refcode' => '47/BAUK/MV.TMS/0317	', 'notes' => 'BAUK ICON+NEWS edisi Maret 2017                                                                                      '),
			array('id' =>  48,	'refdate' => '15/03/2017',	'refcode' => '48/BAST/MV.TMS/0317	', 'notes' => 'BAST ICON+NEWS edisi Maret 2017                                                                                      '),
			array('id' =>  49,	'refdate' => '17/03/2017',	'refcode' => '49/INV.MD/MV.TMS/0317	', 'notes' => 'INV produksi Majalah ICON+NEWS edisi Maret 2017                                                                      '),
			array('id' =>  50,	'refdate' => '16/03/2017',	'refcode' => '50/TT/MV.TMS/0317		', 'notes' => 'Tanda Terima pengiriman Invoice ICON+NEWS Edisi Maret 2017                                                           '),
			array('id' =>  51,	'refdate' => '17/03/2017',	'refcode' => '51/SEK/MV.TMS/0317	', 'notes' => 'Permohonan Pembayaran                                                                                                '),
			array('id' =>  52,	'refdate' => '20/03/2017',	'refcode' => '52/TT/MV.TMS/0317		', 'notes' => 'Tanda Terima pengiriman 1 (satu) DVD foto liputan tanggal 3 Maret 2017 s/d 15 Maret 2017                             '),
			array('id' =>  53,	'refdate' => '21/03/2017',	'refcode' => '53/INV.MD/MV.TMS/0317	', 'notes' => 'INV Energia ed.19                                                                                                    '),
			array('id' =>  54,	'refdate' => '21/03/2017',	'refcode' => '54/INV.MD/MV.TMS/0317	', 'notes' => 'INV Energia ed.20                                                                                                    '),
			array('id' =>  55,	'refdate' => '22/03/2017',	'refcode' => '55/SEK/MV.TMS/0317	', 'notes' => 'Surat Kuasa Penandatanganan e-Faktur                                                                                 '),
			array('id' =>  56,	'refdate' => '22/03/2017',	'refcode' => '56/TT/MV.TMS/0117		', 'notes' => 'Tanda Terima pengiriman Invoice mengenai Produksi Konten Majalah Energia PDSI edisi 19 dan 20 (2017)                 '),
			array('id' =>  57,	'refdate' => '23/03/2017',	'refcode' => '57/INV.MD/MV.TMS/0317	', 'notes' => 'INV produksi konten Majalah e-Magz Info BCA No. 16                                                                   '),
			array('id' =>  58,	'refdate' => '23/03/2017',	'refcode' => '58/INV.MD/MV.TMS/0317	', 'notes' => 'INV produksi konten Majalah Antamedia edisi Februari                                                                 '),
			array('id' =>  59,	'refdate' => '23/03/2017',	'refcode' => '59/TT/MV.TMS/0317		', 'notes' => 'Tanda Terima pengiriman Invoice produksi konten Majalah Antamedia ed. Feb dan e-Magz Info Bca No.16                  '),
			array('id' =>  60,	'refdate' => '24/03/2017',	'refcode' => '60/SDM.KKK/MV.TMS/0317', 'notes' => 'Kontrak Kerja Endra                                                                                                  '),
			array('id' =>  61,	'refdate' => '30/03/2017',	'refcode' => '61/TT/MV.TMS/0317		', 'notes' => 'Tanda Terima pengiriman 2 (satu) DVD foto liputan tanggal 9 Maret 2017 s/d 26 Maret 2017                             '),
			array('id' =>  62,	'refdate' => '30/03/2017',	'refcode' => '62/SDM.KKK/MV.TMS/0317', 'notes' => 'Kontrak Kerja Tiara                                                                                                  '),
			array('id' =>  63,	'refdate' => '31/03/2017',	'refcode' => '63/TT/MV.TMS/0317		', 'notes' => 'Tanda terima pengiriman 1 (satu) majalah RNI edisi 159 Januari 2016                                                  '),
			array('id' =>  64,	'refdate' => '06/04/2017',	'refcode' => '64/INV.MD/MV.TMS/0417	', 'notes' => 'INV produksi konten Majalah Info BCA 264                                                                             '),
			array('id' =>  65,	'refdate' => '06/04/2017',	'refcode' => '65/SDM.KKT/MV.TMS/0417', 'notes' => 'Surat pengangkatan karyawan tetap Mas Rio                                                                            '),
			array('id' =>  66,	'refdate' => '06/04/2017',	'refcode' => '66/PO.CET/MV.TMS/0417	', 'notes' => 'PO cetak di perusahaan bulan april                                                                                   '),
			array('id' =>  67,	'refdate' => '06/04/2017',	'refcode' => '67/TT/MV.TMS/0417		', 'notes' => 'Tanda Terima pengiriman 2 (dua) DVD foto liputan tanggal 23 Maret 2017 s/d 4 April 2017                              '),
			array('id' =>  68,	'refdate' => '07/04/2017',	'refcode' => '68/TT/MV.TMS/0417		', 'notes' => 'Tanda Terima pengiriman invoice konten Majalah Info BCA 264                                                          '),
			array('id' =>  69,	'refdate' => '07/04/2017',	'refcode' => '69/INV.MD/MV.TMS/0417	', 'notes' => 'INV Energia ed.19                                                                                                    '),
			array('id' =>  70,	'refdate' => '07/04/2017',	'refcode' => '70/INV.MD/MV.TMS/0417	', 'notes' => 'INV Energia ed.20                                                                                                    '),
			array('id' =>  71,	'refdate' => '10/04/2017',	'refcode' => '71/TT/MV.TMS/0417		', 'notes' => 'Tanda Terima pengiriman invoice Energia 19 dan 20                                                                    '),
			array('id' =>  72,	'refdate' => '11/04/2017',	'refcode' => '72/SEK/MV.TMS/0417	', 'notes' => 'Persetujuan Klien ICON+NEWS edisi April 2017                                                                         '),
			array('id' =>  73,	'refdate' => '11/04/2017',	'refcode' => '73/SDM.KK/MV.TMS/0417	', 'notes' => 'Surat Keterangan Kerja Mas Budi                                                                                      '),
			array('id' =>  74,	'refdate' => '13/04/2017',	'refcode' => '74/INV.MD/MV.TMS/0417	', 'notes' => 'INV produksi Majalah ICON+NEWS edisi Maret 2017                                                                      '),
			array('id' =>  75,	'refdate' => '13/04/2017',	'refcode' => '75/BAUK/MV.TMS/0417	', 'notes' => 'BAUK ICON+NEWS edisi Maret 2017                                                                                      '),
			array('id' =>  76,	'refdate' => '13/04/2017',	'refcode' => '76/SEK/MV.TMS/0417	', 'notes' => 'Permohonan Pembayaran                                                                                                '),
			array('id' =>  77,	'refdate' => '13/04/2017',	'refcode' => '77/TT/MV.TMS/0417		', 'notes' => 'Tanda terima pengiriman invoice mengenai produksi Majalah ICON+NEWS edisi April 2017                                 '),
			array('id' =>  78,	'refdate' => '13/04/2017',	'refcode' => '78/INV.MD/MV.TMS/0417	', 'notes' => 'INV produksi konten Majalah VIEW Ed. 20                                                                              '),
			array('id' =>  79,	'refdate' => '13/04/2017',	'refcode' => '79/TT/MV.TMS/0417		', 'notes' => 'Tanda terima pengiriman invoice mengenai produksi konten Majalah View 20                                             '),
			array('id' =>  80,	'refdate' => '17/04/2017',	'refcode' => '80/INV.MD/MV.TMS/0417	', 'notes' => 'INV flip magz Majalah VIEW Ed. 20                                                                                    '),
			array('id' =>  81,	'refdate' => '17/04/2017',	'refcode' => '81/TT/MV.TMS/0417		', 'notes' => 'Tanda Terima pengiriman invoice mengenai produksi flip magz Majalah VIEW Ed. 20                                      '),
			array('id' =>  82,	'refdate' => '17/04/2017',	'refcode' => '82/SEK/MV.TMS/0217	', 'notes' => 'Surat kuasa pengambilan data efaktur                                                                                 '),
			array('id' =>  83,	'refdate' => '20/04/2017',	'refcode' => '83/LAT/MV.TMS/0417	', 'notes' => 'Surat permohonan pensponsoran pelatihan lighting fotografi Mas Kun                                                   '),
			array('id' =>  84,	'refdate' => '20/04/2017',	'refcode' => '84/INV.MD/MV.TMS/0417	', 'notes' => 'INV C-News Maret 2017                                                                                                '),
			array('id' =>  85,	'refdate' => '20/04/2017',	'refcode' => '85/TT/MV.TMS/0417		', 'notes' => 'Tanda terima pengiriman 3 (tiga) DVD foto liputan tanggal 30 Maret 2017 s/d 18 April 2017                            '),
			array('id' =>  86,	'refdate' => '21/04/2017',	'refcode' => '86/TT/MV.TMS/0417		', 'notes' => 'Tanda terima pengiriman ulang BAUK ICON+NEWS April 2017                                                              '),
			array('id' =>  87,	'refdate' => '21/04/2017',	'refcode' => '87/TT/MV.TMS/0417		', 'notes' => 'Tanda terima pengirimian invoice mengenai produksi C-News Maret 2017 dan Buletin Info Tol bulan April 2017           '),
			array('id' =>  88,	'refdate' => '21/04/2017',	'refcode' => '88/INV.MD/MV.TMS/0417	', 'notes' => 'INV produksi konten Buletin Info Tol bulan April 2017                                                                '),
			array('id' =>  89,	'refdate' => '25/04/2017',	'refcode' => '89/SEK/MV.TMS/0417	', 'notes' => 'SURAT PENUNJUKAN ADMIN LPSE LKPP                                                                                     '),
			array('id' =>  90,	'refdate' => '25/04/2017',	'refcode' => '90/SEK/MV.TMS/0417	', 'notes' => 'SURAT KUASA membawa dokumen perusahaan untuk LPSE LKPP                                                               '),
			array('id' =>  91,	'refdate' => '02/05/2017',	'refcode' => '91/TT/MV.TMS/0517		', 'notes' => '2 (dua) DVD foto liputan tanggal 23 Maret 2017 s/d 4 April 2017                                                      '),
			array('id' =>  92,	'refdate' => '02/05/2017',	'refcode' => '92/INV.MD/MV.TMS/0517	', 'notes' => 'INV produksi C-News April 2017                                                                                       '),
			array('id' =>  93,	'refdate' => '02/05/2017',	'refcode' => '93/INV.MD/MV.TMS/0517	', 'notes' => 'INV produksi konten Majalah e-Magz Info BCA No. 17                                                                   '),
			array('id' =>  94,	'refdate' => '02/05/2017',	'refcode' => '94/INV.MD/MV.TMS/0517	', 'notes' => 'Tanda Terima pengiriman invoice mengenai produksi konten C-News April 2017 dan Majalah e-Magz Info BCA No. 17        '),
			array('id' =>  95,	'refdate' => '03/05/2017',	'refcode' => '95/INV.MD/MV.TMS/0517	', 'notes' => 'INV Energia ed.21                                                                                                    '),
			array('id' =>  96,	'refdate' => '03/05/2017',	'refcode' => '96/INV.MD/MV.TMS/0517	', 'notes' => 'INV Energia ed.22                                                                                                    '),
			array('id' =>  97,	'refdate' => '03/05/2017',	'refcode' => '97/INV.MD/MV.TMS/0517	', 'notes' => 'Tanda Terima pengiriman invoice Energia 21 dan 22                                                                    '),
			array('id' =>  98,	'refdate' => '04/05/2017',	'refcode' => '98/SEK/MV.TMS/0517	', 'notes' => 'Surat Kuasa aktivasi Efin                                                                                            '),
			array('id' =>  99,	'refdate' => '09/05/2017',	'refcode' => '99					', 'notes' => 'mas pram                                                                                                             '),
			array('id' => 100,	'refdate' => NULL		 ,	'refcode' => '100					', 'notes' => '                                                                                                                     '),
			array('id' => 101,	'refdate' => NULL		 ,	'refcode' => '101					', 'notes' => '                                                                                                                     '),
			array('id' => 102,	'refdate' => '16/05/2017',	'refcode' => '102/PO.CET/MV.TMS/0517', 'notes' => 'PO Cetak ke Kreafindo                                                                                                '),
			array('id' => 103,	'refdate' => '16/05/2017',	'refcode' => '103/SEK/MV.TMS/0517	', 'notes' => 'Persetujuan Klien ICON+NEWS edisi Mei 2017                                                                           '),
			array('id' => 104,	'refdate' => NULL		 ,	'refcode' => '104/INV.MD/MV.TMS/0517', 'notes' => 'Invoice produksi konten Majalah Info BCA 265                                                                         '),
			array('id' => 105,	'refdate' => NULL		 ,	'refcode' => '105/INV.MD/MV.TMS/0517', 'notes' => 'Invoice produksi konten Majalah Edsus 30                                                                             '),
			array('id' => 106,	'refdate' => NULL		 ,	'refcode' => '106/SEK/MV.TMS/0517	', 'notes' => 'Surat kuasa pengambilan data e-faktur                                                                                '),
			array('id' => 107,	'refdate' => NULL		 ,	'refcode' => '107/PJK/MV.TMS/0517	', 'notes' => '                                                                                                                     '),
			array('id' => 108,	'refdate' => '18/05/2017',	'refcode' => '108/TT/MV.TMS/0517	', 'notes' => '4 (empat) DVD foto liputan tanggal 6 April 2017 s/d 15 Meil 2017                                                     '),
			array('id' => 109,	'refdate' => '19/05/2017',	'refcode' => '109/TT/MV.TMS/0517	', 'notes' => 'berkas Proposal Teknis dan Penawaran untuk Pengadaan Website Korporasi ICON+ 2017                                    '),
			array('id' => 110,	'refdate' => '19/05/2017',	'refcode' => '110/TT/MV.TMS/0517	', 'notes' => 'Tanda terima pengiriman invoice tentang produksi konten Majalah Info BCA 265 dan produksi konten Majalah Edsus I-2017'),
			array('id' => 111,	'refdate' => '19/05/2017',	'refcode' => '111/QUO/MV.TMS/0517	', 'notes' => 'Penawaran pengadaan web site icon+                                                                                   '),
			array('id' => 112,	'refdate' => '22/05/2017',	'refcode' => '112/BAUK/MV.TMS/0517	', 'notes' => 'BAUK ICON+NEWS edisi Mei 2017                                                                                        '),
			array('id' => 113,	'refdate' => '22/05/2017',	'refcode' => '113/SEK/MV.TMS/0517	', 'notes' => 'Permohonan pembayaran pengadaan Majalah ICON+NEWS                                                                    '),
			array('id' => 114,	'refdate' => '22/05/2017',	'refcode' => '114/INV.MD/MV.TMS/0517', 'notes' => 'Invoice produksi Majalah ICON+NEWS                                                                                   '),
			array('id' => 115,	'refdate' => '22/05/2017',	'refcode' => '115/INV.MD/MV.TMS/0517', 'notes' => 'Tanda terima pengiriman majalah Icon+News sebanyak 1500 eksemplar                                                    '),

		);
		
		for ( $i = 0; $i < count($data); $i++ ) {
			$d = $data[$i];
			
			$doc = new Model\Admdoc();
			$refcode = explode('/', $d['refcode']);
			
			//$date = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
			$date = DateTime::createFromFormat('d/m/Y', $d['refdate']);
			$mysqltime = null;
			if ($date) {
				$mysqltime = $date->format('Y-m-d');
			}
			var_dump($mysqltime);
			
			$type                      = isset($refcode[1]) ? $refcode[1] : NULL;
			$group                     = isset($refcode[2]) ? $refcode[2] : NULL;
			$doc->id                   = $d['id'];
			$doc->type                 = $type;
			$doc->group                = $group;
			$doc->refcode              = $d['refcode'];
			$doc->refdate              = $mysqltime;
			$doc->notes                = $d['notes'];
			
			$doc->save();
			
		}
		
		$this->db_datatables->sql("ALTER TABLE `$this->table` AUTO_INCREMENT=115;");
	}

	
	private function init_editor() {
		
		// Build our Editor instance and process the data coming from _POST
		$this->editor = Editor::inst( $this->db_datatables, $this->table, 'id' )
			->fields(
				Field::inst( 'id' ),
				Field::inst( 'type' )
					->options( Options::inst()
						->table( 'sip_admin_document_type' )
						->value( 'type' )
						->label( 'type' )
					),
				Field::inst( 'group' )
					->options( Options::inst()
						->table( 'sip_admin_document_group' )
						->value( 'group' )
						->label( 'group' )
					),
				Field::inst( 'refcode' ),
				Field::inst( 'refdate' )
					->validator( 'Validate::dateFormat', array( 'format'=>'d/m/y', 'message'=>'Please enter date (d/m/y)' ) )
					->getFormatter( 'Format::date_sql_to_format', 'd/m/y' )
					->setFormatter( 'Format::date_format_to_sql', 'd/m/y' ),
				Field::inst( 'notes' )
					->validator('Validate::notEmpty')
				,
				Field::inst( 'content' )
			)
		;
	}
	
}