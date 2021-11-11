<?php if (!empty($notif)) {
	echo $notif;
} ?>

<div class="row">
	<div class="col-lg-12">
		<legend class="page-header">Master Signa</legend>
		<hr>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<button type="button" class="btn btn-success" data-toggle="modal" data-backdrop="static" data-target="#tambahSignaModal">Tambah Signa</button>
			</div>
			<br>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode Signa</th>
								<th>Nama Signa</th>
								<th>Catatan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							foreach ($signa as $data) { ?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= $data->signa_kode; ?></td>
									<td><?= $data->signa_nama; ?></td>
									<td><?= $data->additional_data; ?></td>
									<td width="15%">
										<div class="row">
											<div class="col-sm-5">
												<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-backdrop="static" data-target="#editSignaModal" onclick="editSigna(<?= $data->signa_id ?>);">Edit</button>
											</div>
											<div class="col-sm-5">
												<a href="<?= base_url('Signa/delete_signa/' . $data->signa_id); ?>" class="btn btn-danger btn-sm" onclick="return confirmDialog();">Hapus</a>
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

<!-- Modal Tambah Signa -->
<div class="modal fade" id="tambahSignaModal" tabindex="-1" role="dialog" aria-labelledby="tambahSignaModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tambahSignaModalLabel">Tambah Data Signa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="POST" action="<?= base_url('Signa/simpan/save'); ?>" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-3">Kode Signa</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="kode_signa" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Nama Signa</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="nama_signa" required>
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
<!-- Modal Edit Signa -->
<div class="modal fade" id="editSignaModal" tabindex="-1" role="dialog" aria-labelledby="editSignaModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editSignaModalLabel">Edit Data Signa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form role="form" method="POST" action="<?= base_url('Signa/simpan/update'); ?>" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-3">Kode Signa</label>
						<div class="col-sm-7">
							<input type="hidden" class="form-control" name="id_signa" id="id_signa">
							<input type="hidden" class="form-control" name="count_modif" id="count_modif">
							<input type="text" class="form-control" name="kode_signa" id="kode_signa" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3">Nama Signa</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="nama_signa" id="nama_signa" required>
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

	function editSigna(id_signa) {
		$.ajax({
			type: "POST",
			url: "<?= base_url('Signa/edit_signa'); ?>",
			data: {
				id_signa: id_signa
			},
			success: function(response) {
				var dt = jQuery.parseJSON(response);
				$.each(dt, function(i, item) {
					$('#id_signa').val(item.signa_id);
					$('#kode_signa').val(item.signa_kode);
					$('#nama_signa').val(item.signa_nama);
					$('#catatan').val(item.additional_data);
					$('#status').val(item.is_active);
					$('#count_modif').val(item.modified_count);
				});
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {}
		});
	}
</script>