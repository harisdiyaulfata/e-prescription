<?php if (!empty($notif)) {
	echo $notif;
} ?>

<div class="row">
	<div class="col-lg-12">
		<legend class="page-header text-center">Formulir Resep</legend>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-nonracikan-tab" data-toggle="tab" href="#nav-nonracikan" role="tab" aria-controls="nav-nonracikan" aria-selected="true">Non Racikan</a>
						<a class="nav-item nav-link" id="nav-racikan-tab" data-toggle="tab" href="#nav-racikan" role="tab" aria-controls="nav-racikan" aria-selected="false">Racikan</a>
					</div>
				</nav>
				<br>
				<div class="tab-content" id="nav-tabContent">
					<!-- nav non racikan -->
					<div class="tab-pane fade show active" id="nav-nonracikan" role="tabpanel" aria-labelledby="nav-nonracikan-tab">
						<div class="row col-lg-12">
							<div class="form-group col-lg-8">
								<div class="form-group row">
									<label class="col-sm-3">Obat</label>
									<div class="col-sm-9">
										<select class="form-control" name="pilih_obat" id="pilih_obat">
											<option value="">-Pilih-</option>
											<?php foreach ($obat as $dt_obat) {
												if ($dt_obat->stok < 1) {
													$disable = "disabled";
												} else {
													$disable = "";
												} ?>
												<option value="<?= $dt_obat->obatalkes_id . '/' . $dt_obat->stok ?>" <?= $disable ?>><?= $dt_obat->obatalkes_kode . ' (Qty:' . number_format($dt_obat->stok, 0, ',', '.') . ') - ' . $dt_obat->obatalkes_nama ?></option>
											<?php } ?>
										</select>
										<input type="hidden" class="form-control" name="id_obat" id="id_obat">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3">Signa</label>
									<div class="col-sm-9">
										<select class="form-control" name="pilih_signa" id="pilih_signa">
											<option value="">-Pilih-</option>
											<?php foreach ($signa as $dt_signa) { ?>
												<option value="<?= $dt_signa->signa_id ?>"><?= $dt_signa->signa_kode . ' (' . $dt_signa->signa_nama . ')' ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3">Jumlah</label>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="jumlah" id="jumlah" required>
									</div>
									<div class="col-sm-3"></div>
									<div class="col-sm-2">
										<button type="button" class="btn btn-primary btn-md set_obat" value="non_racikan">Set Obat</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- nav racikan -->
					<div class="tab-pane fade" id="nav-racikan" role="tabpanel" aria-labelledby="nav-racikan-tab">
						<div class="row col-lg-12">
							<div class="form-group col-lg-8">
								<div class="form-group row">
									<label class="col-sm-3">Nama Racikan</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="nama_racikan" id="nama_racikan" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3">Signa</label>
									<div class="col-sm-9">
										<select class="form-control" name="signa_racikan" id="signa_racikan">
											<option value="">-Pilih-</option>
											<?php foreach ($signa as $dt_signa) { ?>
												<option value="<?= $dt_signa->signa_id ?>"><?= $dt_signa->signa_kode . ' (' . $dt_signa->signa_nama . ')' ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group col-lg-4"></div>
							<div class="form-group col-lg-2">
								<label>Obat</label>
							</div>
							<div class="form-group col-lg-8">
								<table class="table table-stiped table-bordered table-hover">
									<thead>
										<tr>
											<th>&#x2714;</th>
											<th>Pilih Obat</th>
											<th width="25%">Jumlah</th>
										</tr>
									</thead>
									<tbody id="myTable">
										<tr>
											<td valign="top"><input name="chk[]" type="checkbox" /></td>
											<td>
												<select class="form-control obat_racikan" name="obat_racikan[]">
													<option value="">-Pilih-</option>
													<?php foreach ($obat as $dt_obat) {
														if ($dt_obat->stok < 1) {
															$disable = "disabled";
														} else {
															$disable = "";
														} ?>
														<option value="<?= $dt_obat->obatalkes_id . '/' . $dt_obat->stok ?>" <?= $disable ?>><?= $dt_obat->obatalkes_kode . ' (Qty:' . number_format($dt_obat->stok, 0, ',', '.') . ') - ' . $dt_obat->obatalkes_nama ?></option>
													<?php } ?>
												</select>
												<input type="hidden" class="form-control id_obat_racikan" name="id_obat_racikan[]">
											</td>
											<td>
												<input type="number" class="form-control jumlah_racikan" name="jumlah_racikan[]" required>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" align="center">
												<button type="button" class="btn btn-sm bg-success" style="color: white;" id="tambah_baris" onClick="addRowManual()">Tambah Baris</button>
												<button type="button" class="btn btn-sm bg-warning" style="color: white;" id="hapus_baris" onClick="deleteRow('myTable')">Hapus Baris</button>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="form-group col-lg-2">
								<button type="button" class="btn btn-primary btn-md set_obat" value="racikan">Set Obat</button>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<!-- mulai form -->
				<form role="form" method="POST" action="<?= base_url('Resep/simpan'); ?>" enctype="multipart/form-data">
					<div class="row col-lg-12">
						<div class="form-group col-lg-6">
							<div class="form-group row">
								<label class="col-sm-3">No KTP</label>
								<div class="col-sm-7">
									<input type="text" class="form-control isNumberKey" name="no_ktp" onkeypress="return isNumberKey(event)" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3">Nama Pasien</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="nama_pasien" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3">Alamat</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="alamat" required>
								</div>
							</div>
						</div>
						<div class="form-group col-lg-6">
							<div class="form-group row">
								<label class="col-sm-3">No HP</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="no_hp" onkeypress="return isNumberKey(event)">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3">Diagnosa</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="diagnosa">
								</div>
							</div>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-stiped table-bordered table-hover">
							<thead>
								<tr>
									<th>Jenis</th>
									<th>Nama Obat</th>
									<th>Signa</th>
									<th width="10%">Jumlah</th>
									<th width="6%">Aksi</th>
								</tr>
							</thead>
							<tbody id="tbl_resep">
							</tbody>
						</table>
					</div>
					<button type="submit" class="btn btn-primary simpan_resep" name="submit" value="submit">Simpan</button>
				</form>
				<!-- ahir form -->
			</div>
		</div>
	</div>
</div>
<br>

<script>
	function addRowManual() {
		var html = `<tr>
						<td valign="top"><input name="chk[]" type="checkbox" /></td>
						<td>
							<select class="form-control obat_racikan" name="obat_racikan[]">
								<option value="">-Pilih-</option>
								<?php foreach ($obat as $dt_obat) {
									if ($dt_obat->stok < 1) {
										$disable = "disabled";
									} else {
										$disable = "";
									} ?>
									<option value="<?= $dt_obat->obatalkes_id . '/' . $dt_obat->stok ?>" <?= $disable ?>><?= $dt_obat->obatalkes_kode . ' (Qty:' . number_format($dt_obat->stok, 0, ',', '.') . ') - ' . $dt_obat->obatalkes_nama ?></option>
								<?php } ?>
							</select>
							<input type="hidden" class="form-control id_obat_racikan" name="id_obat_racikan[]">
						</td>
						<td>
							<input type="number" class="form-control jumlah_racikan" name="jumlah_racikan[]" required>
						</td>
					</tr>`;
		$('#myTable').append(html);
		changeSelect();
	}

	$('#pilih_obat').on('change', function() {
		var obat = $(this).val();
		var dt = obat.split('/');

		$('#id_obat').val(dt[0]);
		$("#jumlah").attr({
			"max": dt[1],
			"min": 0,
		});
	});

	$(document).on('change', '.obat_racikan', function() {
		var obat = $(this).val();
		var dt = obat.split('/');

		var kolom_id_obat_racikan = $(this).closest('tr').find('.id_obat_racikan');
		var kolom_jumlah_racikan = $(this).closest('tr').find('.jumlah_racikan');

		kolom_id_obat_racikan.val(dt[0]);
		kolom_jumlah_racikan.attr({
			"max": dt[1],
			"min": 0,
		});
	});

	$('#jumlah').on('keyup', function() {
		var jumlah = $(this).val();
		var obat = $('#pilih_obat').val();
		var dt = obat.split('/');
		var max = parseInt(dt[1]);

		if (eval(jumlah) > eval(max)) {
			alert('Jumlah tidak boleh melebihi Stok ' + max);
			$('#jumlah').val('');
		} else if (eval(jumlah) < 0) {
			alert('Jumlah tidak boleh kurang dari 0');
			$('#jumlah').val('');
		}
	});

	$(document).on('keyup', '.jumlah_racikan', function() {
		var jumlah = $(this).val();
		var obat = $(this).closest('tr').find('.obat_racikan').val();
		var dt = obat.split('/');
		var max = parseInt(dt[1]);

		if (eval(jumlah) > eval(max)) {
			alert('Jumlah tidak boleh melebihi Stok ' + max);
			$(this).closest('tr').find('.jumlah_racikan').val('');
		} else if (eval(jumlah) < 0) {
			alert('Jumlah tidak boleh kurang dari 0');
			$(this).closest('tr').find('.jumlah_racikan').val('');
		}
	});

	$('.set_obat').on('click', function() {
		var jenis = $(this).val();

		if (jenis == 'non_racikan') {
			var id_obat = $('#id_obat').val();
			var id_signa = $('#pilih_signa').val();
			var jumlah = $('#jumlah').val();
			if (id_obat != "" && id_signa != "" && jumlah != "") {
				$.ajax({
					type: "POST",
					url: "<?= base_url('Resep/set_obat'); ?>",
					data: {
						jenis: jenis,
						id_obat: id_obat,
						id_signa: id_signa,
						jumlah: jumlah
					},
					success: function(response) {
						$('#tbl_resep').append(response);
						$('#pilih_obat').val(null).trigger('change');
						$('#pilih_signa').val(null).trigger('change');
						$('#id_obat').val('');
						$('#jumlah').val('');
						$("#jumlah").attr({
							"max": '',
							"min": '',
						});
						changeTable();
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {}
				});
			} else {
				alert('Pastikan sudah mengisi Obat, Signa dan Jumlah !!');
			}
		} else if (jenis == 'racikan') {
			var nama_racikan = $('#nama_racikan').val();
			var id_signa_racikan = $('#signa_racikan').val();
			var id_obat_racikan = $("input[name='id_obat_racikan[]']").map(function() {
				return $(this).val();
			}).get();
			var jumlah_racikan = $("input[name='jumlah_racikan[]']").map(function() {
				return $(this).val();
			}).get();

			if (nama_racikan != "" && id_signa_racikan != "" && id_obat_racikan != "" && jumlah_racikan != "") {
				$.ajax({
					type: "POST",
					url: "<?= base_url('Resep/set_obat'); ?>",
					data: {
						jenis: jenis,
						nama_racikan: nama_racikan,
						id_signa_racikan: id_signa_racikan,
						id_obat_racikan: id_obat_racikan,
						jumlah_racikan: jumlah_racikan
					},
					success: function(response) {
						$('#tbl_resep').append(response);
						$('#nama_racikan').val('');
						$('#signa_racikan').val(null).trigger('change');
						$('.obat_racikan').val(null).trigger('change');
						$('.id_obat_racikan').val('');
						$('.jumlah_racikan').val('');
						$(".jumlah_racikan").attr({
							"max": '',
							"min": '',
						});
						changeTable();
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {}
				});
			} else {
				alert('Pastikan sudah mengisi Nama Racikan, Signa, Obat dan Jumlah !!');
			}
		} else {}
	});

	$('#tbl_resep').on('click', '.hapus_row', function() {
		var hapus = $(this).val();
		if (hapus != "") {
			$('table tr.' + hapus).remove();
		} else {
			$(this).closest("tr").remove();
		}
		changeTable();
	});

	function changeTable() {
		var rowCount = $('#tbl_resep tr').length;
		if (rowCount > 0) {
			$('.simpan_resep').prop('disabled', false);
		} else {
			$('.simpan_resep').prop('disabled', true);
		}
	};

	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		changeSelect();
	});

	function changeSelect() {
		$('#signa_racikan').select2({
			minimumInputLength: 3
		});
		$('.obat_racikan').select2({
			minimumInputLength: 3
		});
	}

	$(document).ready(function() {
		$('.simpan_resep').prop('disabled', true);
		$('#pilih_obat').select2({
			minimumInputLength: 3
		});
		$('#pilih_signa').select2({
			minimumInputLength: 3
		});
	});
</script>