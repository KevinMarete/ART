<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid"> 
		<div class="navbar-header"> 
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
	    	</button>
		    <a class="navbar-brand" href="#">
		      	<span class="glyphicon glyphicon-dashboard"></span>
		    </a>
	    	<a class="navbar-brand" href="#">ART DASHBOARD</a>
		</div> 
		<nav class="collapse navbar-collapse" id="filter-navbar">
			<input type="hidden" name="filter_tab" id="filter_tab" value="" />
			<ul class="nav navbar-nav navbar-right" id="main_tabs">
				<li class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Summary</a></li>
				<li><a href="#trend" aria-controls="trend" role="tab" data-toggle="tab">Trend</a></li>
	          	<li class="dropdown">
	          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	          			County/Subcounty
	          			<span class="caret"></span>
	          		</a>
	          		<ul class="dropdown-menu">
						<li><a href="#county" aria-controls="county" role="tab" data-toggle="tab">County</a></li>
						<li><a href="#subcounty" aria-controls="subcounty" role="tab" data-toggle="tab">Subcounty</a></li>
					</ul>
				</li>
				<li><a href="#facility" aria-controls="facility" role="tab" data-toggle="tab">Facility</a></li>
				<li><a href="#partner" aria-controls="partner" role="tab" data-toggle="tab">Partner</a></li>
				<li><a href="#regimen" aria-controls="regimen" role="tab" data-toggle="tab">Regimen</a></li>
				<li class="dropdown">
	          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	          			ADT
	          			<span class="caret"></span>
	          		</a>
	          		<ul class="dropdown-menu">
						<li><a href="#adt_sites" aria-controls="adt_sites" role="tab" data-toggle="tab">Sites</a></li>
					</ul>
				</li>
	          	<li>
	          		<a href="<?php echo base_url().'admin'; ?>" target="_blank" class="btn btn-success">
	          			<span class="glyphicon glyphicon-log-in"></span> Login
	          		</a>
	          	</li>
			</ul> 
		</nav> 
	</div>
</div>