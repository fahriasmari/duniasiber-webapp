<div class="container-fluid">
	<div class="row">
		<div class="col-md-2"></div>
		
		<div class="col-md-8">
			<h3>Masukan Data Yang Di Perlukan</h3>
			<!-- setelah klik submit langsung diarahkan ke base url -->
			<form method="post" action="<?php echo base_url() ?>dashboard/proses_pesanan">
				<!-- input pembayaran -->
				<div class="form-group">
					<label>Nama Lengkap</label>
					<input type="text" name="nama" placeholder="Nama Lengkap Pemesan" class="form-control">
				</div>

				<div class="form-group">
					<label>Alamat Email</label>
					<input type="text" name="email" placeholder="Verifikasi Email" class="form-control">
				</div>

				<div class="form-group">
					<label>Metode Pembayaran</label>
					<select class="form-control">
						<option>BCA</option>
						<option>BRI</option>
						<option>Mandiri</option>
						<option>PayPal</option>	
					</select>
				</div>

				<button type="submit" class="btn btn-sm btn-primary mb-5">Beli!</button>
			</form>

		</div>
		<div class="col-md-2"></div>
	</div>
</div>