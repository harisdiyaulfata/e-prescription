<?php if (!empty($notif)) {
	echo $notif;
} ?>

<div class="row">
	<div class="col-lg-12">
		<legend class="page-header">Master Obat</legend>
		<hr>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<button type="button" class="btn btn-success" data-toggle="modal" data-backdrop="static" data-target="#tambahObatModal">Tambah Obat</button>
			</div>
			<br>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode Obat</th>
								<th>Nama Obat</th>
								<th>Stok</th>
								<th>Catatan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($obat as $data) { ?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= $data->obatalkes_kode; ?></td>
									<td><?= $data->obatalkes_nama; ?></td>
									<td class="text-right"><?= $data->stok; ?></td>
									<td><?= $data->additional_data; ?></td>
									<td width="15%">
										<div class="row">
											<div class="col-sm-5">
												<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-backdrop="static" data-target="#editObatModal" onclick="editObat(<?= $data->obatalkes_id ?>);">Edit</button>
											</div>
											<div class="col-sm-5">
												<a href="<?= base_url('Obat/delete_obat/' . $data->obatalkes_id); ?>" class="btn btn-danger btn-sm" onclick="return confirmDialog();">Hapus</a>
											</div>
										</div>
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

<!-- Modal Tambah Obat -->
<div class="modal fade" id="tambahObatModal" tabindex="-1" role="dialog" aria-labelledby="tambahObatModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tambahObatModalLabel">Tambah Data Obat</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="POST" action="<?= base_url('Obat/simpan/save'); ?>" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-3">Kode Obat</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="kode_obat" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Nama Obat</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="nama_obat" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Kuantiti</label>
						<div class="col-sm-7">
							<input type="number" class="form-control" name="qty_obat" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Catatan</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="catatan">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" name="submit" value="Submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Edit Obat -->
<div class="modal fade" id="editObatModal" tabindex="-1" role="dialog" aria-labelledby="editObatModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editObatModalLabel">Edit Data Obat</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="POST" action="<?= base_url('Obat/simpan/update'); ?>" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-3">Kode Obat</label>
						<div class="col-sm-7">
							<input type="hidden" class="form-control" name="id_obat" id="id_obat">
							<input type="hidden" class="form-control" name="count_modif" id="count_modif">
							<input type="text" class="form-control" name="kode_obat" id="kode_obat" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Nama Obat</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="nama_obat" id="nama_obat" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Kuantiti</label>
						<div class="col-sm-7">
							<input type="number" class="form-control" name="qty_obat" id="qty_obat" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Catatan</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="catatan" id="catatan">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Status</label>
						<div class="col-sm-7">
							<select class="form-control" name="status" id="status">
								<option value="">-Pilih-</option>
								<option value="1">Aktif</option>
								<option value="0">Non Aktif</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" name="submit" value="Submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function confirmDialog() {
		return confirm("ANDA YAKIN AKAN MENGHAPUS DATA INI?")
	}

	function editObat(id_obat) {
		$.ajax({
			type: "POST",
			url: "<?= base_url('Obat/edit_obat'); ?>",
			data: {
				id_obat: id_obat
			},
			success: function(response) {
				var dt = jQuery.parseJSON(response);
				$.each(dt, function(i, item) {
					$('#id_obat').val(item.obatalkes_id);
					$('#kode_obat').val(item.obatalkes_kode);
					$('#nama_obat').val(item.obatalkes_nama);
					$('#qty_obat').val(parseInt(item.stok));
					$('#catatan').val(item.additional_data);
					$('#status').val(item.is_active);
					$('#count_modif').val(item.modified_count);
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {}
		});
	}
</script>