<div class="container">
	<h3><i class="fas fa-edit"></i>EDIT DATA PAKET</h3>

	<?php foreach ($paket as $pkt): ?>

		<form method="post" action=" <?php echo base_url(). 'admin/data_paket/update' ?> ">

			<div class="for-group">
				<label>Nama Paket</label>
				<input type="text" name="nama_pkt" class="form-control" value="<?php echo $pkt->nama_pkt ?>">
			</div>

			<div class="for-group">
				<label>Keterangan</label>
				<input type="hidden" name="id_pkt" class="form-control" value="<?php echo $pkt->id_pkt ?>">

				<input type="text" name="keterangan" class="form-control" value="<?php echo $pkt->keterangan ?>">
			</div>

			<div class="for-group">
				<label>Kategori</label>
				<input type="text" name="kategori" class="form-control" value="<?php echo $pkt->kategori ?>">
			</div>

			<div class="for-group">
				<label>Harga</label>
				<input type="text" name="harga" class="form-control" value="<?php echo $pkt->harga ?>">
			</div>

			<div class="for-group">
				<label>Stok</label>
				<input type="text" name="stok" class="form-control" value="<?php echo $pkt->stok ?>">
			</div>

			<button type="submit" class="btn btn-primary btn-sm mt-3">simpan</button>

		</form>

	<?php endforeach; ?>

</div>