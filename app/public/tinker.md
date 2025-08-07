$donatur = new App\Models\Donatur();
$donatur->total_amount = 500000;
$donatur->is_paid = false;
$donatur->fundraising_id = 3;
$donatur->notes = "catatan";
$donatur->name = 'Hamba allah';
$donatur->phone_number = '08080808080';
$donatur->proof = 'proofs/bukti.png';
$donatur->save();