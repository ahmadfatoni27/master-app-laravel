@extends('admin_template')
@section('content')
<script>
model.masterModel = {
	id:"",
	name:"",
	price:"",
	stock:"",
	description:"",
	MODE:"",
	select:[],
	idselect:"",
	SELECTFILTERVALUE: [{ name: 'NAME', value: 'name'},{name: 'STOCK', value: 'stock'}],
}
var material = {
	url_dir: ko.observable('/product'),  /* location of Controller file */
	Recordmaterial: ko.mapping.fromJS(model.masterModel),
	Listmaterial: ko.observableArray([]),
	Mode: ko.observable(''),
	CREATEBY: ko.observable('CREATEBY'),
	FilterText: ko.observable(""),
	DataFilter: ko.observableArray(['judul']),
	FilterValue: ko.observable("judul"),
}
material.back = function(tab){
	material.Mode('');
	material.grid.ajax.reload( null, true );
	ko.mapping.fromJS(model.masterModel, material.Recordmaterial);
	model.activetab(tab);
}
material.selectdata = function(id) {
	material.back(0);
	model.Processing(true);
	material.Mode("Update");
	// console.log(id);
	// var url = "http://127.0.0.1:8000/api/products/"+id+"";
	// console.log(url);
	var id = material.Recordmaterial.id(id);
	var url = material.url_dir()+"/GetDataSelect";
	$.ajax({
		url: url,
		type: 'GET',
		data : {id: id},
		success : function(res) {
			console.log(res);
			console.log(res[0]);
			ko.mapping.fromJS(res[0], material.Recordmaterial);
			$("input[name=txtid]").attr("disabled", true);
			model.Processing(false);
		}
	});
}

material.save = function(){
	model.Processing(true);
	var val = material.Recordmaterial;
	val.MODE(material.Mode());
	swal({
		title: "Konfirmasi",
		text: "Apakah data sudah benar??",
		type: "info",
		showCancelButton: true, /* button cancel*/
		closeOnConfirm: false,
		showLoaderOnConfirm: true, /* button Yes*/
	}, function () {
		setTimeout(function(){
			swal({ title: "Good job!",
			text: "Operasi di terima!",
			icon: "success", /* sukses simpan / update */
		});
	}, 2000);
	if (showLoaderOnConfirm=true) {
		if (material.Mode()=="Update") {
			var url = material.url_dir()+"/Update"; // update
			var method = "PUT";
		} else {
			var url = material.url_dir()+"/Insert"; // insert
			var method = "POST";
		}
		$.ajax({
			url: url,
			method: method, // method: 'post' //GET, HEAD, PUT, PATCH, DELETE."
			data : val,
			success : function(res) {
				var res = JSON.parse(res);
				console.log(res);
				material.back(1);
				model.Processing(false); /* end proses simpan / update*/
			}
		});
	}
});
model.Processing(false); /* for process cancel button  */
}

material.remove = function(id){
	// model.Processing(true);
	console.log(id);
	swal({
		title: "Are you sure?",
		text: "Delete this data !"+id,
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Yes!",
		cancelButtonText: "No!",
		closeOnConfirm: false,
	}, function(isConfirm){
		if (isConfirm) {
			$.ajax({
				url: material.url_dir()+"/destroy",
				method: 'DELETE', // it should be method: 'post' //GET, HEAD, PUT, PATCH, DELETE."
				data : {id : id},
				success : function(res) {
					var res = JSON.parse(res);
					console.log(res);
					if (res.result == "OK") {
						material.back(1);
						swal("Deleted!", "Deleted", "success");
					}
					model.Processing(false); /* end proses simpan / update*/
				}
			});

		} // model.Processing(false);
	});
}

material.functionSelect = function() {
url = material.url_dir()+"/functionSelect";
console.log(url);
$.ajax({
		url: url,
		type: 'GET',
		success : function(res) {
			console.log(res);
			$.each(res, function(i, item) {
				var selects = res[i];
				material.Recordmaterial.select.push(selects);
			});
		}
	});
}

</script>


<div class="conatiner-fluid content-inner mt-n5 py-0">
	<div class="row">
		<div class="col-lg-12">
			<div class="card   rounded">
				<div class="card-body" data-bind="with:material">

					<ul class="nav nav-tabs customtab" id="tabnavform" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#tabform" type="button" role="tab" aria-controls="home" aria-selected="true">Form</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="listdata-tab" data-bs-toggle="tab" data-bs-target="#tablist" type="button" role="tab" aria-controls="profile" aria-selected="false">List</button>
						</li>
					</ul>
					<div class="tab-content" id="tabnavform-content">
						<div class="tab-pane fade show active" id="tabform" role="tabpanel" aria-labelledby="home-tab">

							<div class="row p-t-23 margMin" >
								<div class="col-md-12 margMin">
									<div class="form-group ">

										<button data-bind="click:function(){back(1);}, visible: material.Mode() == 'Update'" data-toggle="tooltip" data-placement="top" data-original-title="Kembali" class="btn btn-sm btn-outline-warning mr-1 mb-1" >
											<!-- <i class="bx bx-share"></i> -->
											<span class="icon">
												<svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M11.3 12.2512L20.25 12.2512" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M11.2998 7.25024L3.3628 12.2512L11.2998 17.2522L11.2998 7.25024Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
												</svg>
											</span>
										</button>

										<button data-bind="click:save, data-original-title:Mode" data-toggle="tooltip" data-placement="top" data-original-title="simpan" class="btn btn-icon btn-outline-success mr-1 mb-1">
											<!-- <i class="bx bx-save"></i> -->
											<span class="icon">
												<svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path fill-rule="evenodd" clip-rule="evenodd" d="M14.7366 2.76175H8.08455C6.00455 2.75375 4.29955 4.41075 4.25055 6.49075V17.3397C4.21555 19.3897 5.84855 21.0807 7.89955 21.1167C7.96055 21.1167 8.02255 21.1167 8.08455 21.1147H16.0726C18.1416 21.0937 19.8056 19.4087 19.8026 17.3397V8.03975L14.7366 2.76175Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M14.4741 2.75V5.659C14.4741 7.079 15.6231 8.23 17.0431 8.234H19.7971" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M14.2936 12.9141H9.39355" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M11.8442 15.3639V10.4639" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
												</svg>
											</span>
											Save
										</button>
										<button data-bind=" click:function(){remove(Recordmaterial.id());}, visible: material.Mode() == 'Update'" class="btn btn-icon btn-outline-danger mr-1 mb-1">
											<!-- <i class="bx bx-trash"></i> -->
											<span class="icon">
												<svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                </svg>
											</span>
										</button>
										<button data-bind=" visible: material.Mode() == 'Update'" type="button" class="btn btn-icon btn-light mr-1 mb-1"> no : <i class="bx" data-bind=" text: Recordmaterial.id()"></i> </button>

									</div>
								</div>
							</div>

							<!-- FORM -->
							<div class="form form-vertical" >
								<div class="form-body">
									<div class="row" data-bind="with:Recordmaterial" >

										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="first-name-vertical">name</label>
												<input type="text" name="txtname" data-bind="value: name" id="" required="" class="form-control">
											</div>
										</div>

										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="first-name-vertical">price</label>
												<input type="text" name="txtprice" data-bind="value: price" id="" required="" class="form-control">
											</div>
										</div>

										<div class="col-md-6 col-12">
											<div class="form-group">
												<label for="first-name-vertical">stock</label>
												<input type="text" name="txtstock" data-bind="value: stock" id="" required="" class="form-control">
											</div>
										</div>

										<div class="col-md-6 col-12">

									{{-- <div class="form-group">
										<label for="first-name-vertical">JENIS PAKET</label>
										<select name="txtJENIS_PAKET" data-bind="
										options: select,
										optionsText: 'name',
										optionsValue: 'id',
										value:idselect" class="form-control">
									</select>

								</div> --}}

										<div class="col-md-12 col-12">
											<div class="form-group">
												<label for="first-name-vertical">description</label>
												<input type="text" name="txtdescription" data-bind="value: description" id="" required="" class="form-control">
											</div>
										</div>

									</div>
								</div>
							</div>
							<!-- ./ END FORM -->

						</div>
						<div class="tab-pane fade" id="tablist" role="tabpanel" aria-labelledby="profile-tab">
							<section id="basic-datatable" >

								<div class="row" data-bind="with: material">
									<!-- filter -->
									<div class="col-sm-3 col-md-3 margFilter">
										<fieldset class="form-group">
											<select name="" data-bind="
											options: Recordmaterial.SELECTFILTERVALUE(),
											optionsText: 'name',
											optionsValue: 'value',
											value:FilterValue"
											class="form-control" id="basicSelect">
										</select>
									</fieldset>
								</div>
								<div class="col-sm-3 col-md-3 margFilter">
									<div class="form-group ">
										<input data-bind="value:FilterText" id="" placeholder="Filter by data" class="form-control">
									</div>
								</div>
								<div class="col-sm-3 col-md-3 margFilter">
									<div class="form-group ">
										<button class="btn btn-md btn-danger" data-bind="click:filterreset">
											<span class="icon">
												<svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
													<path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>                                </svg>
											</span>
										</button>
										<button class="btn btn-md btn-primary" data-bind="click:filtermaterial">
											<span class="icon">
												<svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
													<path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
												</svg>
											</span>
										</button>
									</div>
								</div>
								<!-- ./filter -->
								<div class="col-12">
									<div class="table-responsive animated fadeIn" >
										<table id="myTable" width="100%" class="table table-striped zero-configuration">
											<thead>
												<tr>
													<th >name</th>
													<th >price</th>
													<th >stock</th>
													<th >description</th>
													<th >ACTION</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>





			</div>
		</div>
	</div>
</div>
</div>

<script>
material.filtermaterial = function() {
	material.grid.ajax.reload();
}
material.filterreset = function() {
	material.FilterText('');
	material.grid.ajax.reload();
}

material.checkAksesHalaman = function(){
	var URL = document.URL;
	var arr=URL.split('/'); //arr[0]='http' //arr[1]='' //arr[2]='name projek' //arr[3]='name of page'
	var id=arr[4]; //uri='10';
	$.ajax({
		url: "/Admin/getDataUriPage",
		type: 'post', dataType: 'json', data : {id: id},
		success : function(res) {
			var check = res.result;
			if(check!="200") {
				window.location.replace("/Auth/logout");
			}
		}
	});
}
$(document).ready(function(){
	// material.checkAksesHalaman();
	material.functionSelect();
	material.grid = $("#myTable").DataTable({
		"processing": true,
		"serverSide": true,
		"ordering": false,
		"bLengthChange": false,
		"bInfo": true,
		"ajax": {
			"url": material.url_dir()+"/getDataAll",
			"type": "POST",
			"data": function(d){
				d['filtervalue'] = material.FilterValue();
				d['filtertext'] = material.FilterText();
				return d;
			},
			"dataSrc": function (json) {
				// json.draw = 1;
				json.recordsTotal = json.RecordsTotal;
				json.recordsFiltered = json.RecordsFiltered;

				if (json.Data)
				return json.Data;
				else
				return [];
			},
		},
		"searching": false,
		"columns": [
			{"data": "name"},
			{"data": "price"},
			{"data": "stock"},
			{"data": "description"},
			{
				"data": "id",
				"render": function( data, type, full, meta){
					return "<button class='btn btn-icon btn-info' onClick='material.selectdata(\""+data+"\")'><span><svg class='icon-20' width='20' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path><path fill-rule='evenodd' clip-rule='evenodd' d='M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path><path d='M15.1655 4.60254L19.7315 9.16854' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path></svg></span></button> &nbsp; <button  id='sa-warning' class='btn btn-icon btn-danger' onClick='material.remove(\""+data+"\")' id='sa-warning'> <span class='icon'><svg class='icon-20' width='20' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path><path d='M20.708 6.23975H3.75' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path><path d='M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path></svg></span></button>";
				}
			}
		],
	});
});
</script>
@stop
