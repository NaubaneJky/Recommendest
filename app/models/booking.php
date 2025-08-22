<?php
class booking{ 
    public PDO $conn;
    public function __construct(PDO $conn){
        $this->conn = $conn;
    }
// Function addBooking
    public function addBooking($user_id,$destinasi_id,$email,$telp,$tanggal_booking,$tanggal_berangkat,$musim,$jumlah_orang,$note,$diskon,$cashback,$total){
        $stmt = $this->conn->prepare("INSERT INTO booking (user_id, destinasi_id, email, telp, tanggal_booking, tanggal_berangkat, musim, jumlah_orang, note, diskon, cashback, total) VALUES (:user_id, :destinasi_id, :email, :telp, :tanggal_booking, :tanggal_berangkat, :musim, :jumlah_orang, :note, :diskon, :cashback, :total)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':destinasi_id', $destinasi_id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telp', $telp);
        $stmt->bindParam(':tanggal_booking', $tanggal_booking);
        $stmt->bindParam(':tanggal_berangkat', $tanggal_berangkat);
        $stmt->bindParam(':musim', $musim);
        $stmt->bindParam(':jumlah_orang', $jumlah_orang);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':diskon', $diskon);
        $stmt->bindParam(':cashback', $cashback);
        $stmt->bindParam(':total', $total);

        if($stmt->execute()){
            echo "Booking berhasil ditambahkan.";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    }
// Function getBooking
        public function getBooking($id){
            $stmt = $this->conn->prepare("SELECT * FROM booking WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}