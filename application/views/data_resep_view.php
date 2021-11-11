<?php if (!empty($notif)) {
	echo $notif;
} ?>

<div class="row">
	<div class="col-lg-12">
		<legend class="page-header">Daftar Resep</legend>
		<hr>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th width="5">No</th>
								<th>KTP</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>No. HP</th>
								<th>Diagnosa</th>
								<th width="7%">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($resep as $data) { ?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= $data->no_ktp; ?></td>
									<td><?= $data->nama_pasien; ?></td>
									<td><?= $data->alamat; ?></td>
									<td><?= $data->no_hp; ?></td>
									<td><?= $data->diagnosa; ?></td>
									<td>
										<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-backdrop="static" data-target="#lihatResepModal" onclick="lihatResep(<?= $data->header_id ?>);">Lihat</button>
									</td>
								</tr>
							<?php
								$no++;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal lihat resep -->
<div class="modal fade" id="lihatResepModal" tabindex="-1" role="dialog" aria-labelledby="lihatResepModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="lihatResepModalLabel">Detail Resep</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-borderless">
					<tbody id="lihat_laporan"></tbody>
				</table>
				<table class="table table-stiped table-bordered table-hover">
					<thead>
						<tr>
							<th width="6%">No</th>
							<th width="50%">Obat</th>
							<th width="44%">Aturan Pakai</th>
						</tr>
					</thead>
					<tbody id="tableDetail"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary removeDetail" data-dismiss="modal">Close</button>
				<button type="button" name="cetak_laporan" value="cetak_laporan" class="btn btn-primary">Cetak</button>
			</div>
		</div>
	</div>
</div>

<script>
	function confirmDialog() {
		return confirm("ANDA YAKIN AKAN MENGHAPUS DATA INI?")
	}

	function lihatResep(header_id) {
		$.ajax({
			type: "POST",
			url: "<?= base_url('Resep/lihatResep'); ?>",
			data: {
				header_id: header_id
			},
			success: function(response) {
				var dt = response.split('/////');
				$('#lihat_laporan').append(dt[0]);
				$('#tableDetail').append(dt[1]);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {}
		});
	}

	$(document).on('click', '.removeDetail', function() {
		$('#lihat_laporan').empty();
		$('#tableDetail').empty();
	});
</script>