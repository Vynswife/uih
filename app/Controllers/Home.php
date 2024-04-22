<?php 
// File: app/Controllers/Polisi.php
namespace App\Controllers;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
//use Dompdf\Options;
$spreadsheet = new Spreadsheet();

use App\Models\M_polisi;

class Home extends BaseController
{
	protected $M_polisi;
	public function __construct()
    {
        // Inisialisasi objek model M_polisi
        $this->M_polisi = new M_polisi();
    }
	public function beranda()	
	{
		if(session()->get('level')>0){
		echo view('header');
		echo view('menu');
		echo view('beranda');
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
	}
	public function berandas()	
	{
		if(session()->get('level')>0){
		echo view('header');
		echo view('menus');
		echo view('beranda');
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/loginguest');
	}
	}	
	public function beranda1()	
	{
		if(session()->get('level')>0){
		echo view('header');
		echo view('menu1');
		echo view('beranda');
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login2');
	}
}
	public function login()
	{
		echo view('header');
		echo view('login');

	}
	public function aksi_loginadmin()
	{
		$u=$this->request->getPost('nom');
		$p=$this->request->getPost('pass');
		$where= array(
			'nomor_identifikasi'=>$u,
			'pass'=>$p);
		$model = new M_polisi;
		$cek = $model->getWhere('admin',$where);

		if ($cek>0){
			session()->set('nama',$cek->nama);
			session()->set('id',$cek->id);
			session()->set('level',$cek->level);
			session()->set('foto',$cek->foto);
			return redirect()->to('http://localhost:8080/home/beranda/'.session()->get('id'));	
		}else{
			return redirect()->to('http://localhost:8080/home/login');
		}
	}
	public function login1()
	{
		echo view('header');
		echo view('login1');

	}
	public function aksi_loginpolisi()
	{
		$u=$this->request->getPost('nom');
		$p=$this->request->getPost('pass');
		$where= array(
			'nomor_identifikasi'=>$u,
			'password'=>$p);
		$model = new M_polisi;
		$cek = $model->getWhere('polisi',$where);

		if ($cek>0){
			session()->set('nama',$cek->nama);
			session()->set('id',$cek->id_polisi);
			session()->set('level',$cek->level);
			session()->set('foto',$cek->foto);
			return redirect()->to('http://localhost:8080/home/beranda1/'.session()->get('id'));	
		}else{
			return redirect()->to('http://localhost:8080/home/login1');
		}
	}
	public function loginmasyarakat()
	{
		echo view('header');
		echo view('loginmasyarakat');

	}
	public function aksi_loginmasyarakat()
	{
		$u=$this->request->getPost('nom');
		$p=$this->request->getPost('pass');
		$where= array(
			'nomor_identifikasi'=>$u,
			'password'=>$p);
		$model = new M_polisi;
		$cek = $model->getWhere('masyarakat',$where);

		if ($cek>0){
			session()->set('nama',$cek->nama_user);
			session()->set('id',$cek->id);
			session()->set('level',$cek->level);
			session()->set('foto',$cek->foto);
			return redirect()->to('http://localhost:8080/home/berandas/'.session()->get('id'));	
		}else{
			return redirect()->to('http://localhost:8080/home/loginmasyarakat');
		}
	}
	public function register()
	{
		$model= new M_polisi;
		$data['jel']= $model->tampil('masyarakat');
		echo view('header');
		echo view('register',$data);
		echo view('footer');

	}
	public function aksi_t_register()
	{
		$a= $this->request->getPost('nama');
		$b= $this->request->getPost('nom');
		$c= $this->request->getPost('alamat_email');
		$d= $this->request->getPost('tanggal_lahir');
		$e= $this->request->getPost('alamat');
		$f= $this->request->getPost('kontak');
		$k= $this->request->getPost('pass');


		$sis= array(
			'level'=>'3',
			'nama_user'=>$a,
			'nomor_identifikasi'=>$b,
			'alamat_email'=>$c,
			'tanggal_lahir'=>$d,
			'alamat'=>$e,
			'kontak'=>$f,
			'password'=>$k);
		$model= new M_polisi;
		$model->tambah('masyarakat',$sis);
		return redirect()-> to ('http://localhost:8080/home/loginguest');
	}
	public function loginguest()
	{
		echo view('header');
		echo view('loginguest');

	}
	public function aksi_loginguest()
	{
		$u=$this->request->getPost('nom');
		$p=$this->request->getPost('pass');
		$where= array(
			'nomor_identifikasi'=>$u,
			'password'=>$p);
		$model = new M_polisi;
		$cek = $model->getWhere('masyarakat',$where);

		if ($cek>0){
			session()->set('nama',$cek->nama_user);
			session()->set('id',$cek->id);
			session()->set('level',$cek->level);
			session()->set('foto',$cek->foto);
			return redirect()->to('http://localhost:8080/home/berkaslengkap/'.session()->get('id'));	
		}else{
			return redirect()->to('http://localhost:8080/home/loginguest');
		}
	}
	public function berkaslengkap($id)	
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id'=>$id);
		$data['wow']=$model->getWhere('masyarakat',$where);
		echo view('header');
		echo view('berkaslengkap',$data);
	}else{
		return redirect()->to('http://localhost:8080/home/loginguest');
	}
}
	public function aksi_e_berkas()
	{
		$id=$this->request->getPost('id');
		$where = array('id'=>$id);
		$uploadedFile = $this->request->getfile('foto1');
		$a = $uploadedFile->getName();
		$uploadedFile = $this->request->getfile('foto2');
		$b = $uploadedFile->getName();
		$sis= array(
			'foto'=>$a,
			'foto_ktp'=>$b,
			);
		$model= new M_polisi;
		$model->upload($uploadedFile);
		$model->edit('masyarakat',$sis,$where);

		return redirect()-> to ('http://localhost:8080/home/berandas');
	
	}
	public function logout()
	{
		session()->destroy();
		return redirect()->to('http://localhost:8080/home/login');
	}
	public function logout1()
	{
		session()->destroy();
		return redirect()->to('http://localhost:8080/home/loginmasyarakat');
	}
	public function logout2()
	{
		session()->destroy();
		return redirect()->to('http://localhost:8080/home/login1');
	}
	public function form()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jel']= $model->tampil('laporan');
		echo view('header');
		echo view('menus');
		echo view('form',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/loginmasyarakat');
	}
}
	public function aksi_t_form()
	{
		$a= $this->request->getPost('nama');
		$b= $this->request->getPost('nom');
		$c= $this->request->getPost('jenis');
		$d= $this->request->getPost('tingkat');
		$e= $this->request->getPost('kontak');
		$f= $this->request->getPost('lokasi');
		$g= $this->request->getPost('komentar');
		$uploadedFile = $this->request->getfile('foto');
		$foto = $uploadedFile->getName();
		$sis= array(
			'status'=>'Belum di lihat oleh admin',
			'nama_pelapor'=>$a,
			'nomor_identifikasi'=>$b,
			'jenis_keluhan'=>$c,
			'tingkat'=>$d,
			'kontak'=>$e,
			'lokasi'=>$f,
			'penjelasan'=>$g,
			'foto_bukti'=>$foto);
		$model= new M_polisi;
		$model->upload($uploadedFile);
		$model->tambah('laporan',$sis);
		return redirect()-> to ('http://localhost:8080/home/text');
	}
	public function polisi()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('polisi');
		echo view('header');
		echo view('menu');
		echo view('polisi',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
	public function polisi1()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('polisi');
		echo view('header');
		echo view('menu1');
		echo view('polisi1',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/loginmasyarakat');
	}
}
	public function polisi2()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('polisi');
		echo view('header');
		echo view('menus');
		echo view('polisi2',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/loginpolisi');
	}
}
	public function t_polisi()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jel']= $model->tampil('polisi');
		echo view('header');
		echo view('t_polisi',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
	public function aksi_t_polisi()
	{
		$a= $this->request->getPost('nama');
		$b= $this->request->getPost('nom');
		$d= $this->request->getPost('kontak');
		$e= $this->request->getPost('jabatan');
		$f= $this->request->getPost('lokasi');
		$g= $this->request->getPost('jenis');
		$uploadedFile = $this->request->getfile('foto');
		$foto = $uploadedFile->getName();
		$sis= array(
			'level'=>'2',
			'nama'=>$a,
			'nomor_identifikasi'=>$b,
			'kontak'=>$d,
			'jabatan'=>$e,
			'departemen_penugasan'=>$f,
			'jenis'=>$g,
			'foto'=>$foto);
		$model= new M_polisi;
		$model->upload($uploadedFile);
		$model->tambah('polisi',$sis);
		return redirect()-> to ('http://localhost:8080/home/polisi');
	}
	public function e_polisi($id)
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id_polisi'=>$id);
		$data['php']=$model->getWhere('polisi',$where);
		echo view('header');
		echo view('menu');
		echo view('e_polisi',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
	}
	public function aksi_e_polisi()
	{
		$model= new M_polisi;
		$kue= $this->request->getPost('status');
		$id=$this->request->getPost('id');
		$where = array('id_polisi'=>$id);
		$isi= array(
			'status'=>$kue);
		
		$model->edit('polisi',$isi,$where);
		return redirect()-> to ('http://localhost:8080/home/polisi');
	}
	public function h_polisi($id)
	{
		$model= new M_polisi;
		$kil= array('id_polisi'=>$id);
		$model->hapus('polisi',$kil);
		return redirect()-> to('http://localhost:8080/home/polisi');
	}
	public function admin()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('admin');
		echo view('header');
		echo view('menu');
		echo view('admin',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
	public function admin1()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('admin');
		echo view('header');
		echo view('menus');
		echo view('admin1',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/loginmasyarakat');
	}
}
	public function admin2()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('admin');
		echo view('header');
		echo view('menu1');
		echo view('admin2',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/loginpolisi');
	}
}
	public function t_admin()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jel']= $model->tampil('admin');
		echo view('header');
		echo view('t_admin',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
	public function aksi_t_admin()
	{
		$a= $this->request->getPost('nama');
		$b= $this->request->getPost('nom');
		$d= $this->request->getPost('kontak');
		$e= $this->request->getPost('jabatan');
		$f= $this->request->getPost('tanggal');
		$g= $this->request->getPost('jenis');
		$h= $this->request->getPost('pass');
		$i= $this->request->getPost('alamat_email');
		$uploadedFile = $this->request->getfile('foto');
		$foto = $uploadedFile->getName();
		$sis= array(
			'level'=>'1',
			'nama'=>$a,
			'nomor_identifikasi'=>$b,
			'nomor_telpon'=>$d,
			'jabatan'=>$e,
			'tanggal_lahir'=>$f,
			'jk'=>$g,
			'pass'=>$h,
			'alamat_email'=>$i,
			'foto'=>$foto);
		$model= new M_polisi;
		$model->upload($uploadedFile);
		$model->tambah('admin',$sis);
		return redirect()-> to ('http://localhost:8080/home/admin');
	}
	public function e_admin($id)
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id'=>$id);
		$data['php']=$model->getWhere('admin',$where);
		echo view('header');
		echo view('menu');
		echo view('e_admin',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
	}
	public function aksi_e_admin()
	{
		$model= new M_polisi;
		$a= $this->request->getPost('nama');
		$b= $this->request->getPost('nom');
		$d= $this->request->getPost('kontak');
		$e= $this->request->getPost('jabatan');
		$f= $this->request->getPost('tanggal');
		$g= $this->request->getPost('jenis');
		$h= $this->request->getPost('pass');
		$i= $this->request->getPost('alamat_email');
		$id=$this->request->getPost('id');
		$where = array('id'=>$id);
		$uploadedFile = $this->request->getfile('foto');
		$foto = $uploadedFile->getName();
		$sis= array(
			'level'=>'1',
			'nama'=>$a,
			'nomor_identifikasi'=>$b,
			'nomor_telpon'=>$d,
			'jabatan'=>$e,
			'tanggal_lahir'=>$f,
			'jk'=>$g,
			'pass'=>$h,
			'alamat_email'=>$i,
			'foto'=>$foto);
		$model= new M_polisi;
		$model->upload($uploadedFile);
		$model->edit('admin',$sis,$where);
		return redirect()-> to ('http://localhost:8080/home/admin');
	}
	public function h_admin($id)
	{
		$model= new M_polisi;
		$kil= array('id'=>$id);
		$model->hapus('admin',$kil);
		return redirect()-> to('http://localhost:8080/home/admin');
	}
	public function data()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('laporan');
		echo view('header');
		echo view('menu');
		echo view('data',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
	public function data1()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('laporan');
		echo view('header');
		echo view('menu1');
		echo view('data',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login1');
	}
}
public function data2()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('laporan');
		echo view('header');
		echo view('menus');
		echo view('data',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/loginmasyarakat');
	}
}
	public function detail($id)
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id_laporan'=>$id);
		$data['php']=$model->getWhere('laporan',$where);
		echo view('header');
		echo view('menu');
		echo view('detail',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
	}
	public function h_laporan($id)
	{
		$model= new M_polisi;
		$kil= array('id_laporan'=>$id);
		$model->hapus('laporan',$kil);
		return redirect()-> to('http://localhost:8080/home/data');
	}
	public function e_laporan($id)
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id_laporan'=>$id);
		$data['php']=$model->getWhere('laporan',$where);
		echo view('header');
		echo view('menu');
		echo view('e_laporan',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
	}
	public function aksi_e_laporan()
	{
		$model= new M_polisi;
		$a= $this->request->getPost('komentar');
		$b= $this->request->getPost('status');
		$id=$this->request->getPost('id');
		$where = array('id_laporan'=>$id);
		$sis= array(
			'tanggapan'=>$a,
			'status'=>$b);
		$model= new M_polisi;
		$model->edit('laporan',$sis,$where);
		return redirect()-> to ('http://localhost:8080/home/data');
	}
	public function profile($id)	
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id_polisi'=>$id);
		$data['php']=$model->getWhere('polisi',$where);
		echo view('header');
		echo view('menu');
		echo view('profile',$data);
		echo view('footer');
	}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
	public function profile1($id)	
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id_polisi'=>$id);
		$data['php']=$model->getWhere('polisi',$where);
		echo view('header');
		echo view('menu1');
		echo view('profile',$data);
		echo view('footer');
	}else{
		return redirect()->to('http://localhost:8080/home/loginpolisi');
	}
}
	public function profile2($id)	
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id_polisi'=>$id);
		$data['php']=$model->getWhere('polisi',$where);
		echo view('header');
		echo view('menus');
		echo view('profile',$data);
		echo view('footer');
	}else{
		return redirect()->to('http://localhost:8080/home/loginmasyarakat');
	}
}
	public function profilee($id)	
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$where= array('id'=>$id);
		$data['php']=$model->getWhere('masyarakat',$where);
		echo view('header');
		echo view('menus');
		echo view('profilee',$data);
		echo view('footer');
	}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
	public function masyarakat()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		$data['jes']= $model->tampil('masyarakat');
		echo view('header');
		echo view('menu');
		echo view('masyarakat',$data);
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
	public function h_masyarakat($id)
	{
		$model= new M_polisi;
		$kil= array('id'=>$id);
		$model->hapus('masyarakat',$kil);
		return redirect()-> to('http://localhost:8080/home/masyarakat');
	}
	public function text()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		echo view('header');
		echo view('menus');
		echo view('text');
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/loginmasyarakat');
	}
}
	public function laporan()
	{
		if(session()->get('level')>0){
		$model= new M_polisi;
		echo view('header');
		echo view('menu');
		echo view('laporan');
		echo view('footer');
		}else{
		return redirect()->to('http://localhost:8080/home/login');
	}
}
public function generate_excel()
    {
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        if ($start_date && $end_date) {
            $laporan = $this->M_polisi->getLaporanByDateForExcel($start_date, $end_date);

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $sheet->setCellValue('A1', 'Id Laporan')
                  ->setCellValue('B1', 'Nama Pelapor')
                  ->setCellValue('C1', 'Nomor Identifikasi')
                  ->setCellValue('D1', 'Jenis Keluhan')
                  ->setCellValue('E1', 'Tingkat Urgensi')
                  ->setCellValue('F1', 'Nomor kontak')
                  ->setCellValue('G1', 'Lokasi')
                  ->setCellValue('H1', 'Foto Bukti')
                  ->setCellValue('I1', 'Penjelasan')
                  ->setCellValue('J1', 'Status')
                  ->setCellValue('K1', 'Tanggal Keluhan');

            // Fill data
            $rowCount = 2;
            foreach ($laporan as $row) {
                $sheet->setCellValue('A'.$rowCount, $row['id_laporan'])
                      ->setCellValue('B'.$rowCount, $row['nama_pelapor'])
                      ->setCellValue('C'.$rowCount, $row['nomor_identifikasi'])
                      ->setCellValue('D'.$rowCount, $row['jenis_keluhan'])
                      ->setCellValue('E'.$rowCount, $row['tingkat'])
                      ->setCellValue('F'.$rowCount, $row['kontak'])
                      ->setCellValue('G'.$rowCount, $row['lokasi'])
                      ->setCellValue('H'.$rowCount, $row['foto_bukti'])
                      ->setCellValue('I'.$rowCount, $row['penjelasan'])
                      ->setCellValue('J'.$rowCount, $row['status'])
                      ->setCellValue('K'.$rowCount, $row['tanggal_keluhan']);
                $rowCount++;
            }

            // Set response headers
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_keluhan.xlsx"');
            header('Cache-Control: max-age=0');

            // Save the spreadsheet
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        } else {
            return redirect()->back()->with('error', 'Invalid date range.');
        }
    }
public function generate_excell()
    {
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        $data['laporan'] = $this->M_polisi->getLaporanByDateForExcel($start_date, $end_date);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'Id Laporan')
              ->setCellValue('B1', 'Nama Pelapor')
              ->setCellValue('C1', 'Nomor Identifikasi')
              ->setCellValue('D1', 'Jenis Keluhan')
              ->setCellValue('E1', 'Tingkat Urgensi')
              ->setCellValue('F1', 'Nomor kontak')
              ->setCellValue('G1', 'Lokasi')
              ->setCellValue('H1', 'Foto Bukti')
              ->setCellValue('I1', 'Penjelasan')
              ->setCellValue('J1', 'Status')
              ->setCellValue('K1', 'Tanggal Keluhan');

        // Fill data
        $rowCount = 2;
        foreach ($data['laporan'] as $row) {
            $sheet->setCellValue('A'.$rowCount, $row['id_laporan'])
                  ->setCellValue('B'.$rowCount, $row['nama_pelapor'])
                  ->setCellValue('C'.$rowCount, $row['nomor_identifikasi'])
                  ->setCellValue('D'.$rowCount, $row['jenis_keluhan'])
                  ->setCellValue('E'.$rowCount, $row['tingkat'])
                  ->setCellValue('F'.$rowCount, $row['kontak'])
                  ->setCellValue('G'.$rowCount, $row['lokasi'])
                  ->setCellValue('H'.$rowCount, $row['foto_bukti'])
                  ->setCellValue('I'.$rowCount, $row['penjelasan'])
                  ->setCellValue('J'.$rowCount, $row['status'])
                  ->setCellValue('K'.$rowCount, $row['tanggal_keluhan']);
            $rowCount++;
        }

        // Set response headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laporan_keluhan.xlsx"');
        header('Cache-Control: max-age=0');

        // Save the spreadsheet
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
















    public function generatePDF()
    {
        // Buat objek Dompdf
        $dompdf = new Dompdf();

        // Data yang akan digunakan pada tampilan laporan_pdf
        $data = [
            'title' => 'Laporan PDF',
            'content' => 'Ini adalah isi laporan PDF.',
        ];

        // Muat tampilan laporan_pdf dan simpan dalam variabel $html
        $html = view('laporan_pdf', $data);

        // Muat HTML ke objek Dompdf
        $dompdf->loadHtml($html);

        // Render PDF
        $dompdf->render();

        // Tampilkan PDF kepada pengguna atau simpan sebagai file
        $dompdf->stream("laporan.pdf");
    }

public function laporan_pdf()
{
    $model = new M_polisi();

    $start_date = $this->request->getPost('start_date'); 
    $end_date = $this->request->getPost('end_date'); 

    $data['laporan'] = $model->getLaporanByDate($start_date, $end_date); 

    $dompdf = new Dompdf();

    $html = view('laporan_pdf', $data);

    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream("laporan.pdf");

    // Redirect back to the home page after generating PDF
    return redirect()->to(base_url('home/dashboard'));
}


public function generate_window()
{
    if (session()->get('level') > 0) {
        echo view('header');
        echo view('menu');
        echo view('laporan');
        echo view('footer');
    } else {
        return redirect()->to('http://localhost:8080/home/login');
    }
}

public function generate_window_result()
{
    if (session()->get('level') > 0) {
        // Ambil data formulir berdasarkan rentang waktu dari request POST
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');
        $model = new M_polisi();
        $data['formulir'] = $model->getLaporanByDate($start_date, $end_date);

        echo view('cetak_hasil', $data);
    } else {
        return redirect()->to('http://localhost:8080/home/login');
    }
}
}