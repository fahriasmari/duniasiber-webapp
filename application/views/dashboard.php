<!-- buat kelas -->
<div class="container-fluid">
	<!-- buat slider -->
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	  <ol class="carousel-indicators">
	    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	  </ol>
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <img src=" <?= base_url('assets/img/sliderku1.jpg') ?> " class="d-block w-100" alt="...">
	    </div>
	    <div class="carousel-item">
	      <img src="<?= base_url('assets/img/sliderku2.jpg') ?>" class="d-block w-100" alt="...">
	    </div>
	  </div>
	  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
	
	<div class="row text-center mt-4">
		
		<?php foreach ($paket as $pkt) : ?>

		<div class="card ml-3" style="width: 18rem;">
			  <img src=" <?= base_url() . '/uploads/' . $pkt->gambar ?> " class="card-img-top" alt="...">
			  <div class="card-body">
			    <h5 class="card-title mb-1"> <?= $pkt->nama_pkt ?> </h5>
			    <!-- keterangan -->
			    <small> <?= $pkt->keterangan ?> </small>
			    <br>
			   	<span class="badge badge-pill badge-success mb-3"> Rp. <?= $pkt->harga ?> </span>

			   	<br>

			    <a href="#" class="btn btn-sm btn-success">Detail</a>
			    <a href="#" class="btn btn-sm btn-primary">Beli</a>
			  </div>
			</div>

		<?php endforeach; ?>

	</div>
</div>
