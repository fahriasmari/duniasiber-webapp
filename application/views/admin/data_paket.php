<div class="controller-fluid"> 
	<button class = "btn btn-sm btn-primary mb-3" data-toggle="modal" data-target= "#tambah_paket"><i class="fas fa-plus fa-sm"></i>Tambah Paket</button>


	<table class="table table-bordered">
		<tr>
			<th>NO</th>
			<th>NAMA PAKET</th>
			<th>KATEGORI</th>
			<th>KETERANGAN</th>
			<th>HARGA</th>
			<th>STOCK</th>
			<th colspan="3">AKSI</th>
		</tr>

		<?php
		$no=1;
		foreach ($paket as $pkt) : ?>
			<tr>	
				<td> <?php echo $no++ ?>  </td>
				<td> <?php echo $pkt->nama_pkt ?> </td>
				<td> <?php echo $pkt->keterangan ?> </td>
				<td> <?php echo $pkt->kategori ?> </td>
				<td> <?php echo $pkt->harga ?> </td>
				<td> <?php echo $pkt->stok ?> </td>
				<!-- untuk aksi -->
				<td><div class="btn btn-success btn-sm"><i class="fas fa-search-plus"></i></div></td>

				<!-- edit -->
        <!-- divclass dipindahkan setelah id_pkt -->
				<td><?php echo anchor('admin/data_paket/edit/' . $pkt->id_pkt, '<div class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></div>') ?></td>

				<!-- hapus -->
				<td><?php echo anchor('admin/data_paket/hapus/' . $pkt->id_pkt, '<div class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></div>') ?></td>
			</tr>
		<?php endforeach; ?>

	</table>
</div>

<!-- Modal -->
<div class="modal fade" id="tambah_paket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form input paket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url(). 'admin/data_paket/tambah_aksi' ?>" method="post" enctype="multipart/form-data">

        	<div class = "form-group">
        		<label>Nama Barang</label>
        		<input type="text" name="nama_pkt" class="form-control">
        	</div>
        	
        	<div class = "form-group">
        		<label>Keterangan</label>
        		<input type="text" name="keterangan" class="form-control">
        	</div>

        	<div class = "form-group">
        		<label>Kategori</label>
        		<input type="text" name="kategori" class="form-control">
        	</div>

        	<div class = "form-group">
        		<label>Harga</label>
        		<input type="text" name="harga" class="form-control">
        	</div>

        	<div class = "form-group">
        		<label>Stok</label>
        		<input type="text" name="stok" class="form-control">
        	</div>

        	<div class = "form-group">
        		<label>Gambar Produk</label>
        		<input type="file" name="gambar" class="form-control">
        	</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>

      </form>

    </div>
  </div>
</div>