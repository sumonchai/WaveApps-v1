<?php
require_once($_SERVER['DOCUMENT_ROOT']."/assets/func/sqlQu.php");
$login->login_redir();
?>
<script src="../assets/js/mytable/table1.js"></script>
<script src="../assets/js/mytable/table2.js"></script>
<script src="../assets/js/menu-content.js"></script>

<section class="content-header">
  <h1>
	  <i class=""></i>
    <span></span>
  </h1>
  <ol class="breadcrumb">
  </ol>
</section>

<section class="content">
  <nav class="navbar navbar-inverse nav-fixed">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="#" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" role="button">
          <i class="fas fa-bars"></i>
        </a>
        <a class="navbar-brand text-blue" href="<?= $weburl ?>"><span class="fas fa-home"></span></a>
      </div>
      <form class="navbar-form navbar-left">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search Table" id="tableSearch">
          <div class="input-group-btn">
            <button class="btn btn-default clearinput" type="button">
              <i class="fas fa-eraser"></i>
            </button>
          </div>
        </div>
      </form>
      <ul class="nav navbar-nav nav-menu">
        <li class="dropdown">
          <button type="button" class="navbar-btn btn btn-default btn-block disabled" data-toggle="dropdown">
            <span>Action</span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a class="selected-edit pointer">
              <i class="fas fa-edit text-green icoinput"></i> Edit
            </a></li>
            <li><a class="selected-remove pointer">
              <i class="fas fa-trash-alt text-red icoinput"></i> Remove
            </a></li>
          </ul>
        </li>
      </ul>

      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav">
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <button class="btn btn-success navbar-btn btn-block btn-new">New IPv4</button>
        </ul>
      </div>
    </div>
  </nav>
  <div class="row container-data">
    <!-- Table1 - IP Block -->
    <div class="col-md-12">
      <div id="alert"></div>
      <div class="box box-info">
        <div class="box-header" data-widget="collapse">
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle fas fa-sort-numeric-down" data-toggle="dropdown"></a>
            <ul class="dropdown-menu" role="menu">
              <li class="table-length" value="10"><a href="#">10 Entries</a></li>
              <li class="table-length" value="20"><a href="#">20 Entries</a></li>
              <li class="table-length" value="50"><a href="#">50 Entries</a></li>
              <li class="table-length" value="100"><a href="#">100 Entries</a></li>
              <li class="divider"></li>
              <li class="table-length" value="-1"><a href="#">Show All</a></li>
            </ul>
          </div>
          <div class="box-tools pull-right btn-table">
          </div>
        </div>
        <div class="box-body">
          <table id="table1" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead>
              <tr>
                <th><input type="checkbox" class="selectAll"></th>
                <th>Address</th>
                <th>Identity</th>
                <th>Usage</th>
                <th>Notes</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <!-- Table 2 - IP List -->
    <div class="col-md-12">
      <div id="alert"></div>
      <div class="box box-success">
        <div class="box-header" data-widget="collapse">
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle fas fa-sort-numeric-down" data-toggle="dropdown"></a>
            <ul class="dropdown-menu" role="menu">
              <li class="table-length" value="10"><a href="#">10 Entries</a></li>
              <li class="table-length" value="20"><a href="#">20 Entries</a></li>
              <li class="table-length" value="50"><a href="#">50 Entries</a></li>
              <li class="table-length" value="100"><a href="#">100 Entries</a></li>
              <li class="divider"></li>
              <li class="table-length" value="-1"><a href="#">Show All</a></li>
            </ul>
          </div>
          <div class="box-tools pull-right btn-table2">
          </div>
        </div>
        <div class="box-body">
          <table id="table2" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th></th>
                <th>IP Address</th>
                <th>Type</th>
                <th>Used</th>
                <th>Info</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <!-- End Table -->
  </div>
</section>

<script type="text/javascript">
Table1Gen("networking/sql-proc.php?qip=all",
function ( row, data, index ) {
  $('td', row).eq(1).html(data[5]);
});
table.on( 'order.dt search.dt', function () {
    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    });
}).draw();

$('#table1').DataTable().on( 'select', function () {
    $('#table2').DataTable().destroy();
    rowData = table.rows({selected:  true}).data().toArray();
    var newarray=[];
    for (var i=0; i < rowData.length ;i++){
      newarray.push(rowData[i][0]);
    }
    var ipid = newarray;

    Table2Gen({
      "url": 'networking/sql-proc.php?qlist=all',
      "type": 'POST',
      "data": {"ipid": ipid}
    },
    function ( row, data, index ) {
      if (data[3] == "SUBNET" || data[3] == "BROADCAST") {
        $('td', row).eq(0).html("<i class='far fa-dot-circle text-red'></i>");
      } else if (data[3] == ""){
        $('td', row).eq(0).html("<i class='far fa-dot-circle text-green'></i>");
      } else {
        $('td', row).eq(0).html("<i class='far fa-dot-circle text-yellow'></i>");
      }
    });

  });

$('.btn-new').on('click', function() {
  $('#modal-default').modal('show');
  $('#modal-title-default').text("Add New IPv4");
  $('#modal-body-default').load("networking/new-ipv4.php");
});
$('.selected-edit').on('click', function() {
  $('#modal-default').modal('show');
  $('#modal-title-default').text("Edit Selected IPv4");
  $('#modal-body-default').load("networking/edit-ipv4.php");
});
$('.selected-remove').on('click', function() {
  $('#modal-default').modal('show');
  $(".modal-header,.modal-footer").removeClass("error warning success").addClass("warning");
  $(".modal-dialog").removeClass("modal-lg");
  $('#modal-title-default').text("Remove IPv4");
  $('#modal-body-default').load("networking/remove-ipv4.php");
});
</script>
