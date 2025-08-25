<?php
class BookingController {
    private $model;

    public function __construct(){
        $this->model = new BookingModel();
    }

    public function createBooking($user_id,$destinasi_id,$email,$telp,
                                  $tanggal_booking,$tanggal_berangkat,
                                  $jumlah_orang,$note,$diskon,
                                  $cashback,$total)
    {
        $destinasi_id = $_GET['id'] ?? null;

        if (empty($email) || empty($telp)){
            $errors[] = "email dan telepon wajib diisi";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid";
        } else if (!preg_match('/^[0-9]{10,15}$/', $telp)) {
            $errors[] = "Nomor telepon tidak valid";
        } else if ($tanggal_berangkat < $tanggal_booking) {
            $errors[] = "Tanggal berangkat tidak boleh sebelum tanggal booking";
        } else if ($jumlah_orang <= 0) {
            $errors[] = "Jumlah orang harus lebih dari 0";
        }

        $tanggal_booking    = date('Y-m-d H:i:s');
        $tanggal_berangkat  = $_POST['tanggal_berangkat'] ?? null;

        $today = new DateTime('today');
        $berangkat = new DateTime($tanggal_berangkat);

        if ($berangkat <= $today) {
            $errors[] = "Tanggal keberangkatan harus lebih dari hari ini";
        }

        $maksimal_orang = $this->model->getMaksimalOrangById($destinasi_id);
        if ($jumlah_orang > $maksimal_orang) {
            $errors[] = "Jumlah orang melebihi kapasitas maksimal destinasi";
        }

        $hargaperorang = $this->model->getHargaTiketById($destinasi_id);
        $subtotal = $hargaperorang * $jumlah_orang;
// there u go
        $membership = $_SESSION["membership"];

        if ($membership == "Silver") {
            $persentase_diskon = 3;
            $persentase_cashback = 5;
        } else if ($membership == "Gold") {
            $persentase_diskon = 7;
            $persentase_cashback = 10;
        } else {
            $persentase_diskon = 0;
            $persentase_cashback = 0;
        }

        $diskon = $persentase_diskon / 100;
        $cashback = $persentase_cashback / 100;

        return $this->model->addBooking($user_id,$destinasi_id,$email,$telp,
                                  $tanggal_booking,$tanggal_berangkat,
                                  $jumlah_orang,$note,$diskon,
                                  $cashback,$total);
    }

    public function getBooking($id){
        return $this->model->getDetailsBooking($id);
    }

    public function deleteBooking($id){
        return $this->model->deleteBooking($id);
    }
}
